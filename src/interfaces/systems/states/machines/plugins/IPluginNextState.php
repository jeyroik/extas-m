<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginNextState
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginNextState extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IState|null $currentState
     * @param IContext|null $context
     *
     * @return string|false return false if you can not advice next state
     */
    public function __invoke(IStateMachine $machine, IState $currentState = null, IContext $context = null);
}
