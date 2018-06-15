<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginDestructStateMachine
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateMachineDestructed extends IPlugin
{
    /**
     * @param IStateMachine $machine
     *
     * @return mixed
     */
    public function __invoke(IStateMachine &$machine);
}
