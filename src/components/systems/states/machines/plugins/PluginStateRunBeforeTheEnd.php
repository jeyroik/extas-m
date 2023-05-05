<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateRunBefore;

/**
 * Class PluginBeforeStateRunTheEnd
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStateRunBeforeTheEnd extends Plugin implements IPluginStateRunBefore
{
    public $preDefinedStage = IStateMachine::STAGE__STATE_RUN_BEFORE;

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
