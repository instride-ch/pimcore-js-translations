<?php
/**
 * w-vision AG.
 *
 * LICENSE
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that is distributed with this source code.
 *
 * @copyright  Copyright (c) 2019 w-vision AG (https://www.w-vision.ch)
 */

namespace Wvision\Bundle\PimcoreJsTranslationBundle\Command;

use Pimcore\Model\Translation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wvision\Bundle\PimcoreJsTranslationBundle\Filesystem\TranslationFileGeneratorInterface;

class DumpCommand extends Command
{
    /**
     * @var TranslationFileGeneratorInterface
     */
    private $translationFileGenerator;

    /**
     * @param TranslationFileGeneratorInterface $translationFileGenerator
     */
    public function __construct(TranslationFileGeneratorInterface $translationFileGenerator)
    {
        parent::__construct();

        $this->translationFileGenerator = $translationFileGenerator;
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
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $translationList = new Translation\Website\Listing();
        $translationList->setOrderKey('key');
        $translationList->setOrder('asc');
        $translations = $translationList->load();

        if (empty($translations)) {
            $output->writeln('<error>ERROR</error> No translations available!');

            return;
        }

        $outputStyle = new OutputFormatterStyle('white', 'green', ['bold']);
        $output->getFormatter()->setStyle('success', $outputStyle);

        $progress = new ProgressBar($output);
        $progress->setBarCharacter('<info>░</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('<comment>░</comment>');
        $progress->setFormat(' %current%/%max% [%bar%] %percent:3s%% %message%');

        $progress->start(count($translations));

        foreach ($this->translationFileGenerator->generate($translations) as $translation) {
            $progress->setMessage(sprintf('<question>INFO</question> Processing %s', $translation->getKey()));
            $progress->advance();
        }

        $progress->setMessage('<success>DONE</success> Translation files successfully generated!');
        $progress->finish();
    }
}
