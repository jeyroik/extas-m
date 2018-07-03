<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginStateRunBefore;

/**
 * Class PluginBeforeStateRunStart
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStateRunBeforeStart extends Plugin implements IPluginStateRunBefore
{
    const ENV__START_STATE = 'SM__STATE__START';

    public $preDefinedStage = IStateMachine::STAGE__STATE_RUN_BEFORE;

    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        return $stateId
            ?: (
                ($startState = $this->hasEnvStartState())
                    ? $startState
                    : $machine->getConfig()->getStartState()
            );
    }

    /**
     * @return string
     */
    public function hasEnvStartState(): string
    {
        return getenv(static::ENV__START_STATE);
    }
}
