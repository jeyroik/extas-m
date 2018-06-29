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
    const CONFIG__PLUGIN_STORAGE__CLASS = 'plugin_storage_class';

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
     * @param $extasPluginConfigPath
     *
     * @return ICrawlerPackage
     */
    public function registerPlugin($extasPluginConfigPath);

    /**
     * @return ICrawlerPackage[]
     */
    public function getPluginsInfo();

    /**
     * @param string $pluginName
     *
     * @return ICrawlerPackage|null
     */
    public function getPluginInfo($pluginName);
}
