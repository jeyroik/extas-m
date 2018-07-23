<?php
namespace jeyroik\extas\commands\crawlers;

use jeyroik\extas\components\systems\plugins\PluginCrawler;
use jeyroik\extas\interfaces\systems\plugins\IPluginCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * Class CrawlerPluginsCommand
 *
 * @package jeyroik\commands\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerPluginsCommand extends Command
{
    const ARGUMENT__PATH = 'path';
    const ARGUMENT__CRAWLING_CONFIG = 'config';
    const ARGUMENT__REWRITE = 'rw';

    /**
     * Configure the current command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('crawler:plugins')

            // the short description shown while running "php bin/console list"
            ->setDescription('Crawl plugins for Extas.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to crawl and store info about Extas plugins.')
            ->addArgument(
                static::ARGUMENT__PATH,
                InputArgument::REQUIRED,
                'Root path for plugins'
            )
            ->addArgument(
                static::ARGUMENT__CRAWLING_CONFIG,
                InputArgument::REQUIRED,
                'Crawling configuration path'
            )->addArgument(
                static::ARGUMENT__REWRITE,
                InputArgument::OPTIONAL,
                'Rewrite packages: 0 - no, 1 - yes',
                0
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
            'Extas plugin crawler v1.0',
            '=========================='
        ]);

        $rootPath = $input->getArgument(static::ARGUMENT__PATH);
        $config = $this->getConfig($input->getArgument(static::ARGUMENT__CRAWLING_CONFIG));
        $crawler = new PluginCrawler($rootPath, $config);
        try {
            $foundCount = $crawler->crawlPlugins();

            $this->printResults($crawler, $foundCount, $output)
                ->printWarnings($crawler, $output)
                ->askPrintPackages($crawler, $input, $output)
                ->askPrintPlugins($crawler, $input, $output)
                ->askPrintExtensions($crawler, $input, $output);

            return 0;
        } catch (\Exception $e) {
            $output->writeln([
                '<error>Crawling error: '. $e->getMessage() . ' (' . $e->getFile() . ': ' , $e->getLine() . ')</error>'
            ]);
            return $e->getCode();
        }
    }

    /**
     * @param IPluginCrawler $crawler
     * @param int $foundPackagesCount
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function printResults($crawler, $foundPackagesCount, $output)
    {
        $output->writeln([
            '<info> Operated packages: ' . $foundPackagesCount . ' </info>',
            ' ========== From this packages ==================== ',
            ' ========== Plugins ==================== ',
            '<info> Loaded plugins: ' . $crawler->getPluginsLoaded() . ' </info>',
            '<info> Already loaded plugins: ' . $crawler->getPluginsAlreadyLoaded() . ' </info>',
            ' ========== Extensions ==================== ',
            '<info> Loaded extensions: ' . $crawler->getExtensionsLoaded() . ' </info>',
            '<info> Already loaded extensions: ' . $crawler->getExtensionsAlreadyLoaded() . ' </info>',
            ' ============================== '
        ]);

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function printWarnings($crawler, $output)
    {
        if ($crawler->hasWarnings()) {
            $output->writeln([
                'There are some warnings:',
                '<error>' . implode(PHP_EOL, $crawler->getWarnings()) . '</error>'
            ]);
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintPackages($crawler, $input, $output)
    {
        /**
         * @var $helper QuestionHelper
         */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            '<question> - Show operated packages? (y/n)</question>' . PHP_EOL . ' - ',
            false
        );

        if ($helper->ask($input, $output, $question)) {
            $output->writeln([print_r($crawler->getPackages(), true)]);
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintPlugins($crawler, $input, $output)
    {
        /**
         * @var $helper QuestionHelper
         */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            '<question> - Show loaded plugins? (y/n)</question>' . PHP_EOL . ' - ',
            false
        );

        if ($helper->ask($input, $output, $question)) {
            $output->writeln([print_r($crawler->getPlugins(), true)]);
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintExtensions($crawler, $input, $output)
    {
        /**
         * @var $helper QuestionHelper
         */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion(
            '<question> - Show loaded extensions? (y/n)</question>' . PHP_EOL . ' - ',
            false
        );

        if ($helper->ask($input, $output, $question)) {
            $output->writeln([print_r($crawler->getExtensions(), true)]);
        }

        return $this;
    }

    /**
     * @param $configPath
     *
     * @return array|mixed
     */
    protected function getConfig($configPath)
    {
        if (is_file($configPath)) {
            return include $configPath;
        }

        return [];
    }
}
