<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateFactory
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateFactory extends IItem
{
    const SUBJECT = 'factory.state';

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState;
}
