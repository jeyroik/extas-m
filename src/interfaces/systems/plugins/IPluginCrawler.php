<?php
namespace jeyroik\extas\interfaces\systems\plugins;

use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPluginInfo;

/**
 * Interface IPluginCrawler
 *
 * @package jeyroik\extas\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginCrawler
{
    /**
     * IPluginCrawler constructor.
     *
     * @param string $rootPath
     */
    public function __construct($rootPath = '');

    /**
     * @return int found plugins count
     */
    public function crawlPlugins(): int;

    /**
     * @param $extasPluginConfigPath
     *
     * @return ICrawlerPluginInfo
     */
    public function registerPlugin($extasPluginConfigPath);

    /**
     * @return ICrawlerPluginInfo[]
     */
    public function getPluginsInfo();

    /**
     * @param string $pluginName
     *
     * @return ICrawlerPluginInfo|null
     */
    public function getPluginInfo($pluginName);
}
