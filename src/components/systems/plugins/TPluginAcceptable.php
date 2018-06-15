<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;
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
     * @param mixed $subject
     * @param string $stage
     * @param IPlugin $plugin
     *
     * @return bool
     */
    public function registerPlugin($subject, $stage, IPlugin $plugin)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        $pluginRepo::addPluginForStage(
            $subject,
            $stage,
            $plugin->getClass()
        );

        return true;
    }

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

        foreach ($pluginRepo::getPluginsForStage($this, $stage) as $plugin) {
            yield $plugin;
        }
    }

    /**
     * @param array $source
     *
     * @return $this
     */
    protected function registerPlugins($source)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);
        $plugins = $source[IPluginsAcceptable::FIELD__PLUGINS] ?? $source;

        if (!empty($plugins)) {
            $pluginSubjectId = $source[IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID] ?? static::class;
            foreach ($plugins as $pluginConfig) {
                $plugin = new Plugin($pluginConfig);
                $pluginRepo::addPluginForStage($pluginSubjectId, $plugin->getStage(), $plugin->getClass());
            }
        }

        return $this;
    }
}
