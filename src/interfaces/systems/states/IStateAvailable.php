<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateAvailable
 *
 * @package jeyroik\extas\interfaces\systems\states
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
