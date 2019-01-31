<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\repositories\RepositoryClassObjects;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;

/**
 * Class PluginRepository
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginRepository extends RepositoryClassObjects implements IPluginRepository
{
    protected static $stagesWithPlugins = [];

    protected $itemClass = Plugin::class;
    protected $collectionName = 'extas__plugins';

    /**
     * @param $stage
     *
     * @return bool
     */
    public function hasStagePlugins($stage): bool
    {
        if (empty(self::$stagesWithPlugins)) {
            $this->loadStagesWithPlugins();
        }

        return isset(self::$stagesWithPlugins[$stage]);
    }

    /**
     * @param $stage
     *
     * @return \Generator
     */
    public function getStagePlugins($stage)
    {
        if (empty(self::$stagesWithPlugins)) {
            $this->loadStagesWithPlugins();
        }

        $plugins = self::$stagesWithPlugins[$stage] ?? [];

        foreach ($plugins as $index => $plugin) {
            if (is_string($plugin)) {
                $plugin = new $plugin();
                self::$stagesWithPlugins[$stage][$index] = $plugin;
            }
            yield $plugin;
        }
    }

    /**
     *
     */
    protected function loadStagesWithPlugins()
    {
        self::$stagesWithPlugins = array_column(
            $this->group([
                IPlugin::FIELD__STAGE,
                IPlugin::FIELD__CLASS => ['$push' => '$' . IPlugin::FIELD__CLASS]
            ]),
            IPlugin::FIELD__CLASS,
            IPlugin::FIELD__STAGE
        );
    }
}
