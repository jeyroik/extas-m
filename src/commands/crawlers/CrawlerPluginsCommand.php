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
    const ARGUMENT__PRINT__WARNINGS = 'pwa';
    const ARGUMENT__PRINT__RESULTS = 'pre';
    const ARGUMENT__PRINT__PACKAGES = 'ppa';
    const ARGUMENT__PRINT__PLUGINS = 'ppl';
    const ARGUMENT__PRINT__EXTENSIONS = 'pex';

    const PRINT__NO = 0;
    const PRINT__YES = 1;
    const PRINT__ASK = 2;

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
            )->addOption(
                static::ARGUMENT__PRINT__WARNINGS,
                null,
                InputArgument::OPTIONAL,
                'Print warnings: 0 - no, 1 - yes, 2 - ask',
                0
            )->addOption(
                static::ARGUMENT__PRINT__RESULTS,
                null,
                InputArgument::OPTIONAL,
                'Print results: 0 - no, 1 - yes, 2 - ask',
                0
            )->addOption(
                static::ARGUMENT__PRINT__PACKAGES,
                null,
                InputArgument::OPTIONAL,
                'Print operated packages: 0 - no, 1 - yes, 2 - ask',
                0
            )->addOption(
                static::ARGUMENT__PRINT__PLUGINS,
                null,
                InputArgument::OPTIONAL,
                'Print loaded plugins: 0 - no, 1 - yes, 2 - ask',
                0
            )->addOption(
                static::ARGUMENT__PRINT__EXTENSIONS,
                null,
                InputArgument::OPTIONAL,
                'Print loaded extensions: 0 - no, 1 - yes, 2 - ask',
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
            $foundCount = $crawler->crawlPlugins($input->getArgument(static::ARGUMENT__REWRITE));

            $this->printResults($crawler, $foundCount, $input, $output)
                ->printWarnings($crawler, $input, $output)
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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function printResults($crawler, $foundPackagesCount, $input, $output)
    {
        if ($print = $input->getOption(static::ARGUMENT__PRINT__RESULTS)) {
            if ($print == static::PRINT__ASK) {
                /**
                 * @var $helper QuestionHelper
                 */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion(
                    '<question> - Show results? (y/n)</question>' . PHP_EOL . ' - ',
                    false
                );

                if ($helper->ask($input, $output, $question)) {
                    $input->setOption(static::ARGUMENT__PRINT__RESULTS, static::PRINT__YES);
                    $this->printResults($crawler, $foundPackagesCount, $input, $output);
                }
            } else {
                $output->writeln([
                    '<info> Operated packages: ' . $foundPackagesCount . ' </info>',
                    ' ========== From this packages ========== ',
                    '',
                    ' ---------- Plugins ---------- ',
                    '<info> Loaded plugins: ' . $crawler->getPluginsLoaded() . ' </info>',
                    '<info> Already loaded plugins: ' . $crawler->getPluginsAlreadyLoaded() . ' </info>',
                    '',
                    ' ---------- Extensions ---------- ',
                    '<info> Loaded extensions: ' . $crawler->getExtensionsLoaded() . ' </info>',
                    '<info> Already loaded extensions: ' . $crawler->getExtensionsAlreadyLoaded() . ' </info>',
                    ' ============================== '
                ]);
            }
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function printWarnings($crawler, $input, $output)
    {
        if ($print = $input->getOption(static::ARGUMENT__PRINT__WARNINGS)) {
            if ($print == static::PRINT__ASK) {
                /**
                 * @var $helper QuestionHelper
                 */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion(
                    '<question> - Show warnings? (y/n)</question>' . PHP_EOL . ' - ',
                    false
                );

                if ($helper->ask($input, $output, $question)) {
                    $input->setOption(static::ARGUMENT__PRINT__WARNINGS, static::PRINT__YES);
                    $this->printWarnings($crawler, $input, $output);
                }
            } else {
                if ($crawler->hasWarnings()) {
                    $output->writeln([
                        'There are some warnings:',
                        '<error>' . implode(PHP_EOL, $crawler->getWarnings()) . '</error>'
                    ]);
                }
            }
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintPackages($crawler, $input, $output)
    {
        if ($print = $input->getOption(static::ARGUMENT__PRINT__PACKAGES)) {
            if ($print == static::PRINT__ASK) {
                /**
                 * @var $helper QuestionHelper
                 */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion(
                    '<question> - Show operated packages? (y/n)</question>' . PHP_EOL . ' - ',
                    false
                );

                if ($helper->ask($input, $output, $question)) {
                    $input->setOption(static::ARGUMENT__PRINT__PACKAGES, static::PRINT__YES);
                    $this->askPrintPackages($crawler, $input, $output);
                }
            } else {
                $output->writeln([print_r($crawler->getPackages(), true)]);
            }
        }

        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintPlugins($crawler, $input, $output)
    {
        if ($print = $input->getOption(static::ARGUMENT__PRINT__PLUGINS)) {
            if ($print == static::PRINT__ASK) {
                /**
                 * @var $helper QuestionHelper
                 */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion(
                    '<question> - Show loaded plugins? (y/n)</question>' . PHP_EOL . ' - ',
                    false
                );

                if ($helper->ask($input, $output, $question)) {
                    $input->setOption(static::ARGUMENT__PRINT__PLUGINS, static::PRINT__YES);
                    $this->askPrintPlugins($crawler, $input, $output);
                }
            } else {
                $output->writeln([print_r($crawler->getPlugins(), true)]);
            }
        }


        return $this;
    }

    /**
     * @param IPluginCrawler $crawler
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function askPrintExtensions($crawler, $input, $output)
    {
        if ($print = $input->getOption(static::ARGUMENT__PRINT__EXTENSIONS)) {
            if ($print == static::PRINT__ASK) {
                /**
                 * @var $helper QuestionHelper
                 */
                $helper = $this->getHelper('question');
                $question = new ConfirmationQuestion(
                    '<question> - Show loaded extensions? (y/n)</question>' . PHP_EOL . ' - ',
                    false
                );

                if ($helper->ask($input, $output, $question)) {
                    $input->setOption(static::ARGUMENT__PRINT__EXTENSIONS, static::PRINT__YES);
                    $this->askPrintExtensions($crawler, $input, $output);
                }
            } else {
                $output->writeln([print_r($crawler->getExtensions(), true)]);
            }
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
