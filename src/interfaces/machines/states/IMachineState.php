<?php
namespace extas\interfaces\machines\states;

use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\IItem;
use extas\interfaces\parameters\IHasParameters;

/**
 * Interface IState
 *
 * @package jeyroik\extas\interfaces\system
 * @author @author jeyroik@gmail.com
 */
interface IMachineState extends IItem, IHasName, IHasDescription, IHasParameters
{
    const SUBJECT = 'extas.state';

    const FIELD__FROM_STATE = 'from_state';
    const FIELD__ON_SUCCESS = 'on_success';
    const FIELD__ON_FAILURE = 'on_failure';

    /**
     * @return string
     */
    public function getFromState(): string;

    /**
     * @return IMachineStateTransition
     */
    public function getOnSuccess(): IMachineStateTransition;

    /**
     * @return IMachineStateTransition
     */
    public function getOnFailure(): IMachineStateTransition;

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setFromState(string $state);

    /**
     * @param IMachineStateTransition $transition
     *
     * @return $this
     */
    public function setOnSuccess(IMachineStateTransition $transition);

    /**
     * @param IMachineStateTransition $transition
     *
     * @return $this
     */
    public function setOnFailure(IMachineStateTransition $transition);
}
