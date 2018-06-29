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
        $plugins = $pluginRepo->find([IPlugin::FIELD__STAGE => $stage])->all();

        foreach ($plugins as $plugin) {
            yield $plugin;
        }
    }
}
