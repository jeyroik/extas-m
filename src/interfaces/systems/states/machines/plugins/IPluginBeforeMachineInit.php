<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginBeforeMachineInit
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeMachineInit extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param $config
     *
     * @return mixed
     */
    public function __invoke(IStateMachine &$machine, $config);
}
