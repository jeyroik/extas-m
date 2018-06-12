<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IState;

/**
 * Interface IStateAvailable
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateAvailable
{
    /**
     * @return IState|null
     */
    public function getCurrentState();

    /**
     * @return string
     */
    public function getCurrentStateId(): string;

    /**
     * @param string $state
     *
     * @return mixed
     */
    public function setCurrentState($state);
}
