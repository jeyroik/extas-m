<?php
namespace tratabor\components\systems\states\machines;

use tratabor\components\systems\states\StateMachine;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Trait TMachineAvailable
 *
 * WARNING:
 *
 * If you want to have public initialization of your state machine, set  $stateMachineIsPublicInit to "true".
 * Default is "false".
 *
 * @package tratabor\components\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
trait TMachineAvailable
{
    /**
     * @var IStateMachine
     */
    protected $stateMachine = null;

    /**
     * @var int
     */
    protected $stateMachineId = 0;

    /**
     * @var bool
     */
    protected $stateMachineIsPublicInit = false;

    /**
     * @return IStateMachine|null
     */
    public function getStateMachine()
    {
        return $this->stateMachine;
    }

    /**
     * @param string $stateId
     *
     * @return bool
     */
    public function runStateMachine($stateId = '')
    {
        if ($this->stateMachine) {
            $fromState = $this->stateMachine->getCurrentState();
            $stateChangeResult = $this->stateMachine->run($stateId);
            $toState = $this->stateMachine->getCurrentState();

            if (method_exists($this, 'onStateChange')) {
                $this->onStateChange($fromState, $toState, $this->stateMachineId);
            }
            return $stateChangeResult;
        }
        return $this->stateMachine ? $this->stateMachine->run($stateId) : false;
    }

    /**
     * @param $stateConfig
     *
     * @return bool
     */
    public function initStateMachine($stateConfig): bool
    {
        if ($this->stateMachineIsPublicInit) {
            return $this->initStateMachineObject($stateConfig);
        }

        return false;
    }

    /**
     * @param $stateConfig
     *
     * @return bool
     */
    protected function initStateMachineObject($stateConfig)
    {
        $this->stateMachineId = sha1(time() . json_encode($stateConfig) . get_class($this));
        $this->stateMachine = new StateMachine($stateConfig);

        return true;
    }
}
