<?php
namespace jeyroik\extas\components\dispatchers;

use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Class DispatcherAbstract
 *
 * @package jeyroik\extas\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
abstract class DispatcherAbstract implements IStateDispatcher
{
    /**
     * @var IState
     */
    protected $currentState = null;

    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        try {
            $this->currentState = $currentState;
            $context = $this->dispatch($context);
        } catch (\Exception $e) {
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
            $errors = $context->readItem(IStateMachine::CONTEXT__ERRORS)->getValue();
            $errors[] = ['state' => $currentState->getId(), 'error' => $e->getMessage()];
            $context->updateItem(IStateMachine::CONTEXT__ERRORS, $errors);
        }

        return $context;
    }

    /**
     * @param IContext $context
     *
     * @return IContext
     */
    abstract protected function dispatch(IContext $context): IContext;
}
