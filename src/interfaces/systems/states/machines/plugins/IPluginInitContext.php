<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginInitContext
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitContext extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null);
}
