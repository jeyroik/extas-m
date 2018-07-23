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
    const REWRITE__ON = 1;
    const REWRITE__OFF = 0;

    const CONFIG__PACKAGE__ROOT_NAME = 'package.root.name';
    const CONFIG__PACKAGE__ROOT_EXTRACTOR = 'package.root.extractor';

    const CONFIG__PACKAGE__CONFIG_NAME = 'package';
    const CONFIG__PACKAGE__EXTRACTOR = 'package.extractor';

    /**
     * IPluginCrawler constructor.
     *
     * @param string $rootPath
     * @param array $config
     */
    public function __construct($rootPath = '', $config = []);

    /**
     * @param $rewrite
     *
     * @return int found packages count
     */
    public function crawlPlugins($rewrite = 0): int;

    /**
     * @return array
     */
    public function getPlugins(): array;

    /**
     * @return int
     */
    public function getPluginsLoaded(): int;

    /**
     * @return int
     */
    public function getPluginsAlreadyLoaded(): int;

    /**
     * @return array
     */
    public function getExtensions(): array;

    /**
     * @return int
     */
    public function getExtensionsLoaded(): int;

    /**
     * @return int
     */
    public function getExtensionsAlreadyLoaded(): int;

    /**
     * @return ICrawlerPackage[]
     */
    public function getPackages();

    /**
     * @return bool
     */
    public function hasWarnings(): bool;

    /**
     * @return array
     */
    public function getWarnings(): array;
}
