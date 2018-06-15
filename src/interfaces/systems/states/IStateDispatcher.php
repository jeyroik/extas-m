<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateDispatcher
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext;
}
