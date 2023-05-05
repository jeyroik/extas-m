<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginStateRunValid
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateRunValid extends IPluginValidation
{
    /**
     * @param IStateMachine $machine
     * @param IState|null $state
     *
     * @return bool
     */
    public function __invoke(IStateMachine $machine, IState $state = null);

    /**
     * @param IState|null $state
     *
     * @return IState
     */
    public function onValid(IState $state = null);

    /**
     * @param IState|null $state
     *
     * @return string
     */
    public function onInvalid(IState $state = null);
}
