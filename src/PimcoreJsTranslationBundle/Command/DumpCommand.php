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

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Command;

use Pimcore\Model\Translation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem\PimcoreTranslationGeneratorInterface;

class DumpCommand extends Command
{
    /**
     * @var PimcoreTranslationGeneratorInterface
     */
    private $translationGenerator;

    /**
     * @param PimcoreTranslationGeneratorInterface $translationGenerator
     */
    public function __construct(PimcoreTranslationGeneratorInterface $translationGenerator)
    {
        parent::__construct();

        $this->translationGenerator = $translationGenerator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('pimcore:translations:dump-js-translations')
            ->setDescription('Dumps all Pimcore Translations as JavaScript translation files to the filesystem.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $translationList = new Translation\Website\Listing();
        $translationList->setOrderKey('key');
        $translationList->setOrder('asc');
        $translations = $translationList->load();

        if (empty($translations)) {
            $output->writeln('<error>ERROR</error> No translations available!');

            return 500;
        }

        $iterator = $this->translationGenerator->generate($translations);

        if (null === $iterator) {
            $output->writeln('<error>ERROR</error> Translations couldn\'t be generated!');

            return 500;
        }

        $outputStyle = new OutputFormatterStyle('white', 'green', ['bold']);
        $output->getFormatter()->setStyle('success', $outputStyle);

        $progress = new ProgressBar($output);
        $progress->setBarCharacter('<info>░</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('<comment>░</comment>');
        $progress->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');

        $progress->start(count($translations));

        foreach ($iterator as $translation) {
            $progress->setMessage(sprintf('<question>INFO</question> Processing %s', $translation->getKey()));
            $progress->advance();
        }

        $progress->setMessage('<success>DONE</success> Translation files successfully generated!');
        $progress->finish();

        return 0;
    }
}
