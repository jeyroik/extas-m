<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;

/**
 * Class PluginRepository
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginRepository extends RepositoryMongo implements IPluginRepository
{
    protected $itemClass = Plugin::class;
    protected $collectionName = 'extas__plugins';

    /**
     * @return IPlugin[]
     */
    public function all()
    {
        /**
         * @var $pluginsModels IPlugin[]
         */
        $pluginsModels = parent::all();
        $realPlugins = [];

        if (!empty($pluginsModels)) {
            foreach ($pluginsModels as $pluginModel) {
                $className = $pluginModel->getClass();
                $realPlugins[] = new $className();
            }
        }

        return $realPlugins;
    }

    /**
     * @return null|IPlugin
     */
    public function one()
    {
        /**
         * @var $pluginModel IPlugin
         */
        $pluginModel = parent::one();

        if ($pluginModel->getClass()) {
            $className = $pluginModel->getClass();

            return new $className();
        }

        return null;
    }
}
