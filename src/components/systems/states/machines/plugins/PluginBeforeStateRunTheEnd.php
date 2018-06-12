<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateRun;

/**
 * Class PluginBeforeStateRunTheEnd
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateRunTheEnd extends Plugin implements IPluginBeforeStateRun
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return bool|string
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        return ($machine->getCurrentState() && !$stateId)
            ? false // terminating state, so there is no further states
            : $stateId;
    }
}
