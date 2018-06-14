<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateRun;

/**
 * Class PluginBeforeStateRunExistingStateRun
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateRunExistingState extends Plugin implements IPluginBeforeStateRun
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     * @throws \Exception
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        $config = $machine->getConfig();

        if (!$stateId || $config->hasState($stateId)) {
            return $stateId;
        }

        $currentState = $machine->getCurrentState();
        $from = $currentState ? $currentState->getId() : '@directive.initializeMachine()';

        throw new \Exception(
            'Missed or unknown "to" state "' . $stateId . '" from "' . $from . '"'
        );
    }
}
