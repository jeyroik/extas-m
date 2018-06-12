<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginDestructStateMachine
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStateMachineDestructed extends IPlugin
{
    /**
     * @param IStateMachine $machine
     *
     * @return mixed
     */
    public function __invoke(IStateMachine &$machine);
}
