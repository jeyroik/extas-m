<?php
namespace jeyroik\extas\components\systems\states\machines;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Class MachineConfig
 *
 * @package jeyroik\extas\components\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
class MachineConfig extends Item implements IMachineConfig
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $stateId
     *
     * @return bool
     */
    public function hasState($stateId): bool
    {
        $states = $this->getStatesConfig();

        return isset($states[$stateId]);
    }

    /**
     * @param $stateId
     * @param $stateConfig
     *
     * @return $this
     */
    public function setState($stateId, $stateConfig)
    {
        $states = $this->getStatesConfig();
        $states[$stateId] = $stateConfig;

        $this->config[static::FIELD__STATES] = $states;

        return $this;
    }

    /**
     * @param $stateId
     *
     * @return array|mixed
     */
    public function getStateConfig($stateId)
    {
        $states = $this->getStatesConfig();

        return $states[$stateId] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getStatesConfig()
    {
        return $this->config[static::FIELD__STATES] ?? [];
    }

    /**
     * @return string
     */
    public function getEndState(): string
    {
        return $this->config[IStateMachine::MACHINE__CONFIG][static::FIELD__END_STATE] ?? '';
    }

    /**
     * @return string
     */
    public function getStartState(): string
    {
        return $this->config[IStateMachine::MACHINE__CONFIG][static::FIELD__START_STATE] ?? '';
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->config[IStateMachine::MACHINE__CONFIG][static::FIELD__ALIAS] ?? '';
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->config[IStateMachine::MACHINE__CONFIG][static::FIELD__VERSION];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
