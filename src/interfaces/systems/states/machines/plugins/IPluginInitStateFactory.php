<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateFactory;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginInitStateFactory
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitStateFactory extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IStateFactory $stateFactory
     *
     * @return IStateFactory
     */
    public function __invoke(IStateMachine $machine, $stateFactory = null);
}
