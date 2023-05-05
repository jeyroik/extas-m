<?php
namespace jeyroik\extas\interfaces\systems\states\machines;

use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IMachineAvailable
 *
 * @package jeyroik\extas\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineAvailable
{
    /**
     * @return IStateMachine|null
     */
    public function getStateMachine();

    /**
     * @param string $stateId
     *
     * @return bool
     */
    public function runStateMachine($stateId = '');

    /**
     * Return false if public initialization is restricted.
     *
     * @param array $stateConfig
     *
     * @return bool
     */
    public function initStateMachine($stateConfig): bool;
}
