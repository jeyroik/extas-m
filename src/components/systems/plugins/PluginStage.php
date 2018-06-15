<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginStage;

/**
 * Class PluginStage
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStage implements IPluginStage
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string[] plugins class names
     */
    protected $plugins = [];

    /**
     * @var int
     */
    protected $currentKey = 0;

    /**
     * PluginStage constructor.
     *
     * @param $stage
     */
    public function __construct($stage)
    {
        $this->name = $stage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param $pluginClass
     */
    public function addPlugin($pluginClass)
    {
        $this->plugins[] = $pluginClass;
        $this->rewind();
    }

    /**
     * @return bool
     */
    public function hasPlugins(): bool
    {
        return !empty($this->plugins);
    }

    /**
     * @return IPlugin
     */
    public function current()
    {
        $pluginClassName = $this->plugins[$this->currentKey];

        return new $pluginClassName();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->currentKey++;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->plugins[$this->currentKey]);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentKey = 0;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->currentKey;
    }
}
