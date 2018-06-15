<?php
namespace jeyroik\extas\interfaces\systems\states\plugins;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * jeyroik\extas IPluginStateResult
 *
 * @package jeyroik\extas\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateResult extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IContext $context
     *
     * @return bool false if result is not valid
     */
    public function __invoke(IStateMachine &$machine, IContext $context);
}
