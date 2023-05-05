<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateDispatcher
 *
 * @stage.expand.type IStateDispatcher
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\IStateDispatcher
 *
 * @stage.name state.dispatcher.init
 * @stage.description State dispatcher initialization finish
 * @stage.input IStateDispatcher $state
 * @stage.output void
 *
 * @stage.name state.dispatcher.after
 * @stage.description State dispatcher destructing
 * @stage.input IStateDispatcher $state
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateDispatcher extends IItem
{
    const SUBJECT = 'state.dispatcher';

    const STAGE__STATE_DISPATCHER_INIT = 'state.dispatcher.init';
    const STAGE__STATE_DISPATCHER_AFTER = 'state.dispatcher.after';

    /**
     * @param IState $currentState
     * @param IContext $context
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext;
}
