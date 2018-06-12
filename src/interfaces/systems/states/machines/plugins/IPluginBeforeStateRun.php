<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginIsApplicableState
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeStateRun extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     */
    public function __invoke(IStateMachine $machine, $stateId = '');
}
