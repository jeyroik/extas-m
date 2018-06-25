<?php
namespace jeyroik\extas\components\dispatchers;

use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Class DispatcherAbstract
 *
 * @require_interface jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors
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
     * @var string[]
     */
    protected $requireInterfaces = [];

    /**
     * DispatcherAbstract constructor.
     */
    public function __construct()
    {
        $this->initDefault();
    }

    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     * @throws \Exception
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        if (!$this->isContextImplementAllRequiredInterfaces($context)) {
            throw new \Exception(
                'Not all interfaces are implemented: ' . implode(', ', $this->requireInterfaces)
            );
        }

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
     * @return $this
     */
    protected function initDefault()
    {
        if (!in_array(ExtensionContextErrors::class, $this->requireInterfaces)) {
            $this->requireInterfaces[] = ExtensionContextErrors::class;
        }

        return $this;
    }

    /**
     * @param IContext $context
     *
     * @return bool
     */
    protected function isContextImplementAllRequiredInterfaces(IContext $context)
    {
        foreach ($this->requireInterfaces as $interface) {
            if (!$context->isImplementsInterface($interface)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param IContext $context
     *
     * @return IContext
     */
    abstract protected function dispatch(IContext $context): IContext;
}
