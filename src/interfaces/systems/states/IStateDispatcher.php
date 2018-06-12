<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;

/**
 * Interface IStateDispatcher
 *
 * @package tratabor\interfaces\systems\states
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
