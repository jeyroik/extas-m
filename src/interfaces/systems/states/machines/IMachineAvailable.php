<?php
namespace tratabor\interfaces\systems\states\machines;

use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IMachineAvailable
 *
 * @package tratabor\interfaces\systems\states\machines
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
