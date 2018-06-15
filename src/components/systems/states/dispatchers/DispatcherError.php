<?php
namespace jeyroik\extas\components\systems\states\dispatchers;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class DispatcherError
 *
 * todo: log an error
 *
 * @package jeyroik\extas\components\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherError implements IStateDispatcher
{
    /**
     * @var \Exception|null
     */
    protected $error = null;

    /**
     * DispatcherError constructor.
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->error = $e;
    }

    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $context->updateItem('success', false);

        return $context;
    }
}
