<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginInitContext;

/**
 * Class PluginInitContextSuccess
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginInitContextSuccess extends Plugin implements IPluginInitContext
{
    const CONTEXT__SUCCESS = '@directive.success()';

    /**
     * @param IStateMachine $machine
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null)
    {
        /**
         * Try to get context_success item.
         * If this is sub-machine, than this item is already exists - so we don't need to do anything.
         * If this is primary machine, than item is not exists, so exception will be thrown.
         */
        try {
            $context->readItem(PluginInitContextSuccess::CONTEXT__SUCCESS);
        } catch (\Exception $e) {
            $context->pushItemByName(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        }

        return $context;
    }
}
