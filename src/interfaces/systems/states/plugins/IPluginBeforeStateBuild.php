<?php
namespace tratabor\interfaces\systems\states\plugins;

use tratabor\interfaces\systems\IPlugin;

/**
 * Interface IPluginBeforeStateBuild
 *
 * @package tratabor\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeStateBuild extends IPlugin
{
    /**
     * @param array $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return array [stateConfig, fromState, stateId]
     */
    public function __invoke($stateConfig = [], $fromState = '', $stateId = '');
}
