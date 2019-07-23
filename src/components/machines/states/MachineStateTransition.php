<?php
namespace extas\components\machines\states;

use extas\components\Item;
use extas\interfaces\machines\IMachine;
use extas\interfaces\machines\IMachineRepository;
use extas\interfaces\machines\states\IMachineState;
use extas\interfaces\machines\states\IMachineStateTransition;

/**
 * Class StateTransition
 *
 * @package extas\components\states
 * @author jeyroik@gmail.com
 */
class MachineStateTransition extends Item implements IMachineStateTransition
{
    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->config[static::FIELD__STATE] ?? '';
    }

    /**
     * @return IMachine|null
     */
    public function getMachine(): ?IMachine
    {
        /**
         * @var $machineRepo IMachineRepository
         */
        $machineName = $this->config[static::FIELD__MACHINE] ?? '';

        return $machineRepo->one([IMachine::FIELD__NAME => $machineName]);
    }

    /**
     * @return bool
     */
    public function hasMachine(): bool
    {
        return isset($this->config[static::FIELD__MACHINE]);
    }

    /**
     * @return bool
     */
    public function hasState(): bool
    {
        return isset($this->config[static::FIELD__STATE]);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->hasMachine() && !$this->hasState();
    }

    /**
     * @param IMachine|string $machine
     *
     * @return $this
     */
    public function setMachine($machine)
    {
        $this->config[static::FIELD__MACHINE] = $machine instanceof IMachine
            ? $machine->getName()
            : (string) $machine;

        return $this;
    }

    /**
     * @param IMachineState|string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->config[static::FIELD__STATE] = $state instanceof IMachineState
            ? $state->getName()
            : (string) $state;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
