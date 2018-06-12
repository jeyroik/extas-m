<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginInitStateMachine
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitStateMachine extends IPlugin
{
    /**
     * @param IStateMachine $machine
     *
     * @return bool|IMachineConfig
     */
    public function __invoke(IStateMachine &$machine);
}
