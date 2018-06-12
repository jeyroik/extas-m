<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginInitContext;

/**
 * Class PluginInitContextErrors
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginInitContextErrors extends Plugin implements IPluginInitContext
{
    /**
     * @param IStateMachine $machine
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null)
    {
        /**
         * Try to get context_errors item.
         * If this is sub-machine, than this item is already exists - so we don't need to do anything.
         * If this is primary machine, than item is not exists, so exception will be thrown.
         */
        try {
            $context->readItem(IStateMachine::CONTEXT__ERRORS);
        } catch (\Exception $e) {
            $context->pushItemByName(IStateMachine::CONTEXT__ERRORS, []);
        }

        return $context;
    }
}
