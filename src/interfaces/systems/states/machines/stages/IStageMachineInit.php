<?php
namespace jeyroik\extas\interfaces\systems\states\machines\stages;

use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IStageMachineInit
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\stages
 * @author Funcraft <me@funcraft.ru>
 */
interface IStageMachineInit
{
    public function __invoke(IStateMachine &$machine);
}
