<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginBeforeStateBuild
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeStateBuild extends IPlugin
{
    /**
     * @param $machine
     * @param array $stateConfig
     * @param $fromStateId
     * @param $stateId
     *
     * @return array [stateConfig, fromStateId, stateId]
     */
    public function __invoke(IStateMachine &$machine, $stateConfig, $fromStateId, $stateId);
}
