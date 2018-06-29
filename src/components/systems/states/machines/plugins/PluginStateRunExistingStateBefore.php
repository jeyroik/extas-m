<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateRunBefore;

/**
 * Class PluginBeforeStateRunExistingStateRun
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStateRunExistingStateBefore extends Plugin implements IPluginStateRunBefore
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
