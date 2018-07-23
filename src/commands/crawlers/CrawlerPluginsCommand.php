<?php
namespace jeyroik\extas\commands\crawlers;

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
    const ARGUMENT__PRINT = 'print';
    const ARGUMENT__CRAWLING_CONFIG = 'config';

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
            ->addArgument(
                static::ARGUMENT__CRAWLING_CONFIG,
                InputArgument::REQUIRED,
                'Crawling configuration path'
            )
            ->addArgument(
                static::ARGUMENT__PRINT,
                InputArgument::OPTIONAL,
                'Print mode: 0 - hash, 1 - full',
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

            $output->writeln([
                '<info> Found plugins: ' . $foundCount . ' </info>',
                '<info> Already loaded plugins: ' . $crawler->getAlreadyLoadedPluginsCount() . ' </info>',
                ' ============================== '
            ]);

            if ($crawler->hasWarnings()) {
                $output->writeln([
                    'There are some warnings:',
                    implode(PHP_EOL, $crawler->getWarnings())
                ]);
            }

            $plugins = $crawler->getPackagesInfo();

            count($plugins) && $output->writeln([
                'Plugins list:'
            ]);

            $printMode = $input->getArgument(static::ARGUMENT__PRINT);

            foreach ($plugins as $plugin) {
                $printMode
                    ? $output->writeln([$plugin->getName(), print_r($plugin, true)])
                    : $output->writeln([$plugin->getName() . ': ' . $plugin->getVersion()]);
            }

            return 0;
        } catch (\Exception $e) {
            $output->writeln([
                'Crawling error: '. $e->getMessage() . ' (' . $e->getFile() . ': ' , $e->getLine() . ')'
            ]);
            return $e->getCode();
        }
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
