<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginBeforeMachineInit
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeMachineInit extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param $config
     *
     * @return mixed
     */
    public function __invoke(IStateMachine &$machine, $config);
}
