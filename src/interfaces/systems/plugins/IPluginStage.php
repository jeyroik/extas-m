<?php
namespace tratabor\interfaces\systems\plugins;

use tratabor\interfaces\systems\IPlugin;

/**
 * Interface IPluginStage
 *
 * @package tratabor\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStage extends \Iterator
{
    /**
     * IPluginStage constructor.
     *
     * @param $stageName
     */
    public function __construct($stageName);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param $pluginClass
     *
     * @return $this
     */
    public function addPlugin($pluginClass);

    /**
     * @return bool
     */
    public function hasPlugins(): bool;

    /**
     * @return IPlugin
     */
    public function current();
}
