<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginInitConfig
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitConfig extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param mixed $config
     *
     * @return IMachineConfig|mixed
     */
    public function __invoke(IStateMachine $machine, $config = null);
}
