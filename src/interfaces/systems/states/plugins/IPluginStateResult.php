<?php
namespace tratabor\interfaces\systems\states\plugins;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginStateResult
 *
 * @package tratabor\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateResult extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IContext $context
     *
     * @return bool false if result is not valid
     */
    public function __invoke(IStateMachine &$machine, IContext $context);
}
