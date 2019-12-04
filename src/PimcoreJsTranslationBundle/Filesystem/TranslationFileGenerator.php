<?php
/**
 * Pimcore JavaScript Translations.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2016-2019 w-vision AG (https://www.w-vision.ch)
 * @license    https://github.com/w-vision/PimcoreJsTranslationBundle/blob/master/LICENSE GNU General Public License version 3 (GPLv3)
 */

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem;

use Generator;
use InvalidArgumentException;
use OutOfRangeException;
use Pimcore\Model\Translation\AbstractTranslation;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\MessageCatalogue;
use Wvision\Bundle\PimcoreJsTranslationBundle\Dumper\PimcoreTranslationDumperInterface;
use Wvision\Bundle\PimcoreJsTranslationBundle\Loader\PimcoreTranslationLoaderInterface;

class TranslationFileGenerator implements TranslationFileGeneratorInterface
{
    /**
     * @var string
     */
    private $domainName;

    /**
     * @var PimcoreTranslationDumperInterface
     */
    private $dumper;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var PimcoreTranslationLoaderInterface
     */
    private $loader;

    /**
     * @var string
     */
    private $translationDirectory;

    /**
     * @param string $domainName
     * @param PimcoreTranslationDumperInterface $dumper
     * @param Filesystem $filesystem
     * @param PimcoreTranslationLoaderInterface $loader
     */
    public function __construct(
        string $domainName,
        PimcoreTranslationDumperInterface $dumper,
        Filesystem $filesystem,
        PimcoreTranslationLoaderInterface $loader
    ) {
        $this->domainName = $domainName;
        $this->dumper = $dumper;
        $this->filesystem = $filesystem;
        $this->loader = $loader;

        $this->translationDirectory = __DIR__ . '/../Resources/translations';

    }

    /**
     * {@inheritdoc}
     */
    public function generate(array $translations): ?Generator
    {
        if (empty($translations)) {
            throw new InvalidArgumentException('No translations available');
        }

        foreach ($translations as $translation) {
            $this->update($translation);

            yield $translation;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function update(AbstractTranslation $translation): void
    {
        $translations = $translation->getTranslations();

        if (empty($translations)) {
            throw new OutOfRangeException(
                sprintf('No translations available for "%s"', $translation->getKey())
            );
        }

        foreach ($translations as $locale => $content) {
            if (empty($content)) {
                continue;
            }

            $translationFilePath = sprintf(
                '%s/%s.%s.xlf',
                $this->translationDirectory,
                $this->domainName,
                $locale
            );

            // Check if catalogue already exists
            if ($this->filesystem->exists($translationFilePath)) {
                $catalogue = $this->loader->load($translationFilePath, $locale);
            } else {
                $catalogue = new MessageCatalogue($locale);
            }

            // Add translation to catalogue
            $this->addToCatalogue($catalogue, $translation->getKey(), $content);

            // Dump message catalogue as translation file to filesystem
            $this->filesystem->dumpFile(
                $translationFilePath,
                $this->dumper->dump($catalogue)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(AbstractTranslation $translation): void
    {
        $translations = $translation->getTranslations();

        if (empty($translations)) {
            throw new OutOfRangeException(
                sprintf('No translations available for "%s"', $translation->getKey())
            );
        }

        foreach (array_keys($translations) as $locale) {
            $translationFilePath = sprintf(
                '%s/%s.%s.xlf',
                $this->translationDirectory,
                $this->domainName,
                $locale
            );

            // Check if catalogue exists
            if (!$this->filesystem->exists($translationFilePath)) {
                continue;
            }

            $catalogue = $this->loader->load($translationFilePath, $locale);

            // Check if translation key exists
            if (!$catalogue->has($translation->getKey(), $this->domainName)) {
                continue;
            }

            // Remove translation from catalogue
            $messages = $catalogue->all($this->domainName);
            unset($messages[$translation->getKey()]);

            if (count($messages) > 0) {
                // Create new message catalogue with updates messages
                $newCatalogue = new MessageCatalogue($locale, [$this->domainName => $messages]);

                // Dump message catalogue as translation file to filesystem
                $this->filesystem->dumpFile(
                    $translationFilePath,
                    $this->dumper->dump($newCatalogue)
                );
            } else {
                // Remove translation file
                $this->filesystem->remove($translationFilePath);
            }
        }
    }

    /**
     * Either adds or overwrites a translation in the message catalogue.
     *
     * @param MessageCatalogue $catalogue
     * @param string $id
     * @param string $translation
     */
    protected function addToCatalogue(MessageCatalogue $catalogue, string $id, string $translation): void
    {
        if ($catalogue->has($id, $this->domainName)) {
            $catalogue->replace([$id => $translation], $this->domainName);
        } else {
            $catalogue->add([$id => $translation], $this->domainName);
        }
    }
}
