<?php
namespace jeyroik\commands\crawlers;

use jeyroik\extas\components\systems\plugins\PluginCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CrawlerPluginsCommand
 *
 * @package jeyroik\commands\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerPluginsCommand extends Command
{
    const ARGUMENT__PATH = 'path';

    /**
     * Configure the current command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('jeyroik:crawler-plugins')

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
        $crawler = new PluginCrawler($rootPath);
        try {
            $foundCount = $crawler->crawlPlugins();

            $output->writeln([
                'Found plugins: ' . $foundCount,
                '=============================='
            ]);

            $output->writeln([
                'Plugins list:'
            ]);

            $plugins = $crawler->getPluginsInfo();

            foreach ($plugins as $plugin) {
                $output->writeln([$plugin->getName() . ': ' . $plugin->getInfoHash()]);
            }

            return 0;
        } catch (\Exception $e) {
            $output->writeln(['Crawling error: '. $e->getMessage()]);
            return $e->getCode();
        }
    }
}
