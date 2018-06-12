<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateRun;

/**
 * Class PluginBeforeStateRunStart
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateRunStart implements IPluginBeforeStateRun
{
    const ENV__START_STATE = 'SM__STATE__START';

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
