<?php
namespace jeyroik\extas\interfaces\systems\plugins;

use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;

/**
 * Interface IPluginCrawler
 *
 * @package jeyroik\extas\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginCrawler
{
    const CONFIG__PACKAGE__ROOT_NAME = 'package.root.name';
    const CONFIG__PACKAGE__ROOT_EXTRACTOR = 'package.root.extractor';

    const CONFIG__PACKAGE__NAME = 'package';
    const CONFIG__PACKAGE__EXTRACTOR = 'package.extractor';

    /**
     * IPluginCrawler constructor.
     *
     * @param string $rootPath
     * @param array $config
     */
    public function __construct($rootPath = '', $config = []);

    /**
     * @return int found plugins count
     */
    public function crawlPlugins(): int;

    /**
     * @return ICrawlerPackage[]
     */
    public function getPackagesInfo();
}
