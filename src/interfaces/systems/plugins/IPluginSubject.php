<?php
namespace tratabor\interfaces\systems\plugins;

use tratabor\interfaces\systems\IPlugin;

/**
 * Interface IPluginSubject
 *
 * @package tratabor\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginSubject
{
    /**
     * IPluginSubject constructor.
     *
     * @param $subject
     */
    public function __construct($subject);

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @param $stageName
     *
     * @return mixed
     */
    public function addStage($stageName);

    /**
     * @param $stageName
     *
     * @return bool
     */
    public function hasStage($stageName): bool;

    /**
     * @param $stageName
     * @param $pluginName
     *
     * @return mixed
     */
    public function addPlugin($stageName, $pluginName);

    /**
     * @param $stageName
     *
     * @return bool
     */
    public function hasPlugins($stageName): bool;

    /**
     * @param $stageName
     *
     * @return \Generator|IPlugin
     */
    public function getPlugins($stageName);
}
