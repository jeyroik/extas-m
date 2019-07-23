<?php
namespace extas\interfaces\machines\states;

use extas\interfaces\IItem;
use extas\interfaces\machines\IMachine;

/**
 * Interface IStateTransition
 *
 * @package extas\interfaces\states
 * @author jeyroik@gmail.com
 */
interface IMachineStateTransition extends IItem
{
    const SUBJECT = 'extas.machine.state.transition';

    const FIELD__MACHINE = 'machine';
    const FIELD__STATE = 'state';

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @return IMachine|null
     */
    public function getMachine(): ?IMachine;

    /**
     * @return bool
     */
    public function hasMachine(): bool;

    /**
     * @return bool
     */
    public function hasState(): bool;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param string|IState $state
     *
     * @return $this
     */
    public function setState($state);

    /**
     * @param string|IMachine $machine
     *
     * @return $this
     */
    public function setMachine($machine);
}
