<?php
namespace extas\components\machines\states;

use extas\components\Item;
use extas\components\parameters\THasParameters;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\interfaces\machines\states\IMachineState;
use extas\interfaces\machines\states\IMachineStateTransition;

/**
 * Class State
 *
 * @package extas\components\states
 * @author jeyroik@gmail.com
 */
class MachineState extends Item implements IMachineState
{
    use THasName;
    use THasDescription;
    use THasParameters;

    /**
     * @return string
     */
    public function getFromState(): string
    {
        return $this->config[static::FIELD__FROM_STATE] ?? '';
    }

    /**
     * @return IMachineStateTransition
     */
    public function getOnSuccess(): IMachineStateTransition
    {
        $transition = $this->config[static::FIELD__ON_SUCCESS] ?? [];

        return new MachineStateTransition($transition);
    }

    /**
     * @return IMachineStateTransition
     */
    public function getOnFailure(): IMachineStateTransition
    {
        $transition = $this->config[static::FIELD__ON_FAILURE] ?? [];

        return new MachineStateTransition($transition);
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setFromState(string $state)
    {
        $this->config[static::FIELD__FROM_STATE] = $state;

        return $this;
    }

    /**
     * @param IMachineStateTransition $transition
     *
     * @return $this
     */
    public function setOnSuccess(IMachineStateTransition $transition)
    {
        $this->config[static::FIELD__ON_SUCCESS] = $transition->__toArray();

        return $this;
    }

    /**
     * @param IMachineStateTransition $transition
     *
     * @return $this
     */
    public function setOnFailure(IMachineStateTransition $transition)
    {
        $this->config[static::FIELD__ON_FAILURE] = $transition->__toArray();

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
