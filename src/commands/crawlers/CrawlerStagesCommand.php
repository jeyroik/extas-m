<?php
namespace jeyroik\extas\commands\crawlers;

use jeyroik\extas\components\systems\plugins\PluginStageProducer;
use jeyroik\extas\components\systems\plugins\stages\StageRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class CrawlerStagesCommand
 *
 * @package jeyroik\commands\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerStagesCommand extends Command
{
    const ARGUMENT__PATH = 'path';
    const ARGUMENT__PRINT = 'print';
    const ARGUMENT__CRAWLING_CONFIG = 'config';

    /**
     * Configure the current command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('jeyroik:crawler-stages')

            // the short description shown while running "php bin/console list"
            ->setDescription('Crawl stages for Extas.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to crawl and store stages info about Extas plugins.')
            ->addArgument(
                static::ARGUMENT__PATH,
                InputArgument::REQUIRED,
                'Root path for packages with stages'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Extas stages crawler v1.0',
            '=========================='
        ]);

        $rootPath = $input->getArgument(static::ARGUMENT__PATH);
        $crawler = new PluginStageProducer($rootPath);
        try {
            $stagesCount = $crawler->findStages();

            $output->writeln(['Found ' . $stagesCount . ' stages.']);

            /**
             * @var $helper QuestionHelper
             */
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Show found stages?', false);

            if ($helper->ask($input, $output, $question)) {
                $output->writeln([print_r($crawler->getStages(), true)]);
            }

            /**
             * @var $helper QuestionHelper
             */
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Save found stages?', false);

            if ($helper->ask($input, $output, $question)) {
                $saved = $crawler->saveStages(new StageRepository(), $crawler->getStages());
                $output->writeln(['Saved ' . $saved . ' stages.']);
            }

            return 0;
        } catch (\Exception $e) {
            $output->writeln(['Crawling error: '. $e->getMessage()]);
            return $e->getCode();
        }
    }
}
