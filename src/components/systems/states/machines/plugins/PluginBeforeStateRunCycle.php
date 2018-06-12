<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateRun;

/**
 * Class PluginBeforeStateRunCycle
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateRunCycle implements IPluginBeforeStateRun
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return bool|string
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        $currentState = $machine->getCurrentState();

        if ($currentState && ($currentState == $stateId)) {
            // it seems to be an infinity cycle
            // break it
            return false;
        }

        return $stateId;
    }
}
