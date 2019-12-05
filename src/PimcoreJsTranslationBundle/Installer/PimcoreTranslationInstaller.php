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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Installer;

use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;
use Pimcore\Extension\Bundle\Installer\MigrationInstaller;
use Pimcore\Model\Translation;
use Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem\PimcoreTranslationGeneratorInterface;

class PimcoreTranslationInstaller extends MigrationInstaller
{
    /**
     * @var PimcoreTranslationGeneratorInterface
     */
    private $translationGenerator;

    /**
     * @param PimcoreTranslationGeneratorInterface $translationGenerator
     */
    public function setTranslationGenerator(PimcoreTranslationGeneratorInterface $translationGenerator): void
    {
        $this->translationGenerator = $translationGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function migrateInstall(Schema $schema, Version $version): void
    {
        $translationList = new Translation\Website\Listing();
        $translationList->setOrderKey('key');
        $translationList->setOrder('asc');
        $translationsToInstall = $translationList->load();

        if (empty($translationsToInstall)) {
            $this->outputWriter->write('<fg=red>ERROR:</> No translations available!');

            return;
        }

        foreach ($this->translationGenerator->generate($translationsToInstall) as $translation) {
            $this->outputWriter->write(sprintf('<fg=cyan>STATUS:</> Processing %s', $translation->getKey()));
        }

        $this->outputWriter->write(
            '<fg=green>DONE:</> Pimcore JavaScript Translations have been successfully installed!'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function migrateUninstall(Schema $schema, Version $version)
    {
        $this->translationGenerator->cleanupTranslationFiles();
        $this->outputWriter->write(
            '<fg=green>DONE:</> Pimcore JavaScript Translations have been successfully uninstalled!'
        );
    }
}
