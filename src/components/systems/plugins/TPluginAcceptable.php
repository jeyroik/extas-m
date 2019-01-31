<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;

/**
 * Trait TPluginAcceptable
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
trait TPluginAcceptable
{
    /**
     * @param $stage
     *
     * @return \Generator|IPlugin
     */
    public function getPluginsByStage($stage)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);
        if ($pluginRepo->hasStagePlugins($stage)) {
            $logIndex = PluginLog::log($this, $stage);
            foreach ($pluginRepo->getStagePlugins($stage) as $plugin) {
                PluginLog::logPluginClass(get_class($plugin), $logIndex);
                yield $plugin;
            }
        }
    }
}
