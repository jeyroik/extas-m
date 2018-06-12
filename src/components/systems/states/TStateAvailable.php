<?php
namespace tratabor\components\systems\states;

use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\machines\IMachineAvailable;

/**
 * Trait TStateAvailable
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
trait TStateAvailable
{
    /**
     * State Machine (sm) state
     *
     * @var IState
     */
    protected $smState = null;

    /**
     * @return null|IState
     */
    public function getCurrentState()
    {
        if (!$this->smState) {
            if (($this instanceof IMachineAvailable) && $this->getStateMachine()) {
                $this->smState = $this->getStateMachine()->getCurrentState();
            }
        }

        return $this->smState;
    }

    /**
     * @return string
     */
    public function getCurrentStateId(): string
    {
        $currentState = $this->getCurrentState();

        return $currentState ? $currentState->getId() : '';
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setCurrentState($state)
    {
        if ($this instanceof IMachineAvailable) {
            $this->runStateMachine($state);
        }

        return $this;
    }
}
