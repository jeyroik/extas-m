<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use jeyroik\extas\interfaces\systems\plugins\IPluginSubject;

/**
 * Class PluginRepository
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginRepository implements IPluginRepository
{
    /**
     * @var static
     */
    protected static $repository = null;

    /**
     * @var IPluginSubject[]
     */
    protected $subjects = [];

    /**
     * @param mixed $subject
     * @param string $stageName
     * @param string $pluginClass
     *
     * @return bool
     */
    public static function addPluginForStage($subject, $stageName, $pluginClass)
    {
        $subjectName = is_object($subject) ? get_class($subject) : $subject;

        static::getInstance()->registerPlugin($subjectName, $stageName, $pluginClass);

        return true;
    }

    /**
     * @param $subject
     * @param $stageName
     *
     * @return \Generator|IPlugin
     */
    public static function getPluginsForStage($subject, $stageName)
    {
        $subjectName = is_object($subject) ? get_class($subject) : $subject;

        foreach (static::getInstance()->getPlugins($subjectName, $stageName) as $plugin) {
            yield $plugin;
        }
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return static::$repository ?: static::$repository = new static();
    }

    /**
     * @param $subjectName
     *
     * @return $this
     */
    public function registerSubject($subjectName)
    {
        !isset($this->subjects[$subjectName]) && $this->subjects[$subjectName] = new PluginSubject($subjectName);

        return $this;
    }

    /**
     * @param $subjectName
     *
     * @return bool
     */
    public function hasSubject($subjectName)
    {
        return isset($this->subjects[$subjectName]);
    }

    /**
     * @param $subjectName
     *
     * @return IPluginSubject
     */
    public function getSubject($subjectName): IPluginSubject
    {
        if (!isset($this->subjects[$subjectName])) {
            $this->registerSubject($subjectName);
        }

        return $this->subjects[$subjectName];
    }

    /**
     * @param IPluginSubject $subject
     *
     * @return $this
     */
    public function setSubject(IPluginSubject $subject)
    {
        $this->subjects[$subject->getName()] = $subject;

        return $this;
    }

    /**
     * @param $subjectName
     * @param $stageName
     *
     * @return $this
     */
    public function registerStage($subjectName, $stageName)
    {
        $this->setSubject(
            $this->getSubject($subjectName)
                ->addStage($stageName)
        );

        return $this;
    }

    /**
     * @param $subjectName
     * @param $stageName
     *
     * @return mixed
     */
    public function hasStage($subjectName, $stageName)
    {
        return $this->getSubject($subjectName)->hasStage($stageName);
    }

    /**
     * @param $subjectName
     * @param $stageName
     * @param $pluginClass
     *
     * @return $this
     */
    public function registerPlugin($subjectName, $stageName, $pluginClass)
    {
        $this->getSubject($subjectName)->addPlugin($stageName, $pluginClass);

        return $this;
    }

    /**
     * @param $subjectName
     * @param $stageName
     *
     * @return bool
     */
    public function hasPlugins($subjectName, $stageName)
    {
        return $this->getSubject($subjectName)->hasPlugins($stageName);
    }

    /**
     * @param $subjectName
     * @param $stageName
     *
     * @return \Generator
     */
    public function getPlugins($subjectName, $stageName)
    {
        foreach ($this->getSubject($subjectName)->getPlugins($stageName) as $plugin) {
            yield $plugin;
        }
    }
}
