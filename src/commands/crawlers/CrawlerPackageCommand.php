<?php
namespace jeyroik\extas\commands\crawlers;

use jeyroik\extas\components\systems\packages\PackageGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CrawlerPackageCommand
 *
 * @package jeyroik\commands\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerPackageCommand extends Command
{
    const ARGUMENT__PATH_TO_SEARCH = 'pts';
    const ARGUMENT__PATH_TO_PUT = 'ptp';
    const ARGUMENT__CONFIG_NAME = 'config';

    /**
     * Configure the current command.
     */
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('jeyroik:crawler-package')

            // the short description shown while running "php bin/console list"
            ->setDescription('Generate Extas package config.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to generate Extas package config.')
            ->addArgument(
                static::ARGUMENT__PATH_TO_SEARCH,
                InputArgument::REQUIRED,
                'Path to search plugins and extensions'
            )
            ->addArgument(
                static::ARGUMENT__PATH_TO_PUT,
                InputArgument::REQUIRED,
                'Path where to put result config',
                ''
            )
            ->addArgument(
                static::ARGUMENT__CONFIG_NAME,
                InputArgument::OPTIONAL,
                'Result config name. Default is extas.json',
                'extas.json'
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
            'Extas package generator v1.0',
            '=========================='
        ]);

        $whereToSearch = $input->getArgument(static::ARGUMENT__PATH_TO_SEARCH);
        $whereToStore = $input->getArgument(static::ARGUMENT__PATH_TO_PUT);
        $packageConfigName = $input->getArgument(static::ARGUMENT__CONFIG_NAME);

        $packageGenerator = new PackageGenerator($whereToSearch, $whereToStore, $packageConfigName);
        try {
            $generated = $packageGenerator->generate();
            $output->writeln('Config successfully generated');
            $output->writeln('See ' . $packageConfigName);
        } catch (\Exception $e) {
            $output->writeln('Can not generate package config');
            $output->writeln($e->getMessage());
        }

        return 0;
    }
}
