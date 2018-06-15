<?php
namespace jeyroik\extas\components\dispatchers;

use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use jeyroik\extas\interfaces\systems\states\IStateMachine;


/**
 * Class DispatcherTest
 * 
 * @package jeyroik\extas\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherSuccess implements IStateDispatcher
{
    protected static $counter = 0;

    /**
     * @param IState $currentState
     * @param IContext $context
     * 
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $context->pushItemByName(static::class . '.' . static::$counter, 'worked');
        $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);

        static::$counter++;

        return $context;
    }
}
