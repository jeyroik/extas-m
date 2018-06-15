<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginInitStateMachine
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitStateMachine extends IPlugin
{
    /**
     * @param IStateMachine $machine
     *
     * @return bool|IMachineConfig
     */
    public function __invoke(IStateMachine &$machine);
}
