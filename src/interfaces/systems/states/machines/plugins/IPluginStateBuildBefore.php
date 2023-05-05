<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginBeforeStateBuild
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateBuildBefore extends IPlugin
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
