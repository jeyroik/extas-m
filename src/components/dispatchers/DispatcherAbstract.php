<?php
namespace jeyroik\extas\components\dispatchers;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\contexts\IContextErrors;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class DispatcherAbstract
 *
 * @require_interface jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors
 *
 * @package jeyroik\extas\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
abstract class DispatcherAbstract extends Item implements IStateDispatcher
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
     * @var array
     */
    protected $missedInterfaces = [];

    /**
     * DispatcherAbstract constructor.
     */
    public function __construct()
    {
        $this->initDefault();

        parent::__construct();
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
                'Not all interfaces for ' . get_class($this)
                . ' are implemented: ' . implode(', ', $this->missedInterfaces)
            );
        }

        try {
            $this->currentState = $currentState;
            $context = $this->dispatch($context);
        } catch (\Exception $e) {
            $context[PluginInitContextSuccess::CONTEXT__SUCCESS] = false;
            /**
             * @var $context ExtensionContextErrors
             */
            $context->addError(['state' => $currentState->getId(), 'error' => $e->getMessage()]);
        }

        return $context;
    }

    /**
     * @return $this
     */
    protected function initDefault()
    {
        if (!in_array(ExtensionContextErrors::class, $this->requireInterfaces)) {
            $this->requireInterfaces[] = IContextErrors::class;
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
                $this->missedInterfaces[] = $interface;
            }
        }

        return empty($this->missedInterfaces);
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }

    /**
     * @param IContext $context
     *
     * @return IContext
     */
    abstract protected function dispatch(IContext $context): IContext;
}
