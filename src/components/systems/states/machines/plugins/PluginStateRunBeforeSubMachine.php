<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateRunBefore;

/**
 * Class PluginBeforeStateRunSubMachine
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStateRunBeforeSubMachine extends Plugin implements IPluginStateRunBefore
{
    public $preDefinedStage = IStateMachine::STAGE__STATE_RUN_BEFORE;

    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        /**
         * State is a StateMachine
         */
        if (is_array($stateId)) {
            /**
             * @var $subMachine IStateMachine
             */
            $subMachine = new $machine($stateId, $machine->getCurrentContext());
            return $subMachine->run($stateId);
        }

        return $stateId;
    }
}
