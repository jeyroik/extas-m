<?php



require __DIR__ . '/../../../../autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new \jeyroik\extas\commands\crawlers\CrawlerPluginsCommand());
$application->add(new \jeyroik\extas\commands\crawlers\CrawlerPackageCommand());
$application->run();
