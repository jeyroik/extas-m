<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginStage;
use jeyroik\extas\interfaces\systems\plugins\IPluginSubject;

/**
 * Class PluginSubject
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginSubject implements IPluginSubject
{
    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var IPluginStage[]
     */
    protected $stages = [];

    /**
     * PluginSubject constructor.
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->name = $subject;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $stageName
     *
     * @return $this
     */
    public function addStage($stageName)
    {
        $this->stages[$stageName] = new PluginStage($stageName);

        return $this;
    }

    /**
     * @param $stageName
     *
     * @return bool
     */
    public function hasStage($stageName): bool
    {
        return isset($this->stages[$stageName]);
    }

    /**
     * @param $stageName
     * @param $pluginClass
     *
     * @return $this
     */
    public function addPlugin($stageName, $pluginClass)
    {
        if (!$this->hasStage($stageName)) {
            $this->addStage($stageName);
        }

        $this->stages[$stageName]->addPlugin($pluginClass);

        return $this;
    }

    /**
     * @param $stageName
     *
     * @return bool
     */
    public function hasPlugins($stageName): bool
    {
        return $this->hasStage($stageName) ? $this->stages[$stageName]->hasPlugins() : false;
    }

    /**
     * @param $stageName
     *
     * @return \Generator|IPlugin
     */
    public function getPlugins($stageName)
    {
        if ($this->hasStage($stageName)) {
            foreach ($this->stages[$stageName] as $plugin) {
                yield $plugin;
            }
        }
    }
}
