<?php
namespace tratabor\interfaces\systems\plugins;

use tratabor\interfaces\systems\IPlugin;

/**
 * Interface IPluginRepository
 *
 * @package tratabor\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginRepository
{
    /**
     * @param mixed $subject
     * @param string $stageName
     * @param string $pluginClass
     *
     * @return bool
     */
    public static function addPluginForStage($subject, $stageName, $pluginClass);

    /**
     * @param mixed $subject
     * @param string $stageName
     *
     * @return \Generator|IPlugin
     */
    public static function getPluginsForStage($subject, $stageName);
}
