<?php
namespace tratabor\components\dispatchers;

use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class DispatcherFail
 *
 * @package tratabor\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherFail implements IStateDispatcher
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
        $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);

        static::$counter++;

        return $context;
    }
}
