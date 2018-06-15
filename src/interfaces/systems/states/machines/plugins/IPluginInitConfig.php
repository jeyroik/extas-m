<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginInitConfig
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitConfig extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param mixed $config
     *
     * @return IMachineConfig|mixed
     */
    public function __invoke(IStateMachine $machine, $config = null);
}
