<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateFactory
 *
 * @stage.expand.type IStateFactory
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\IStateFactory
 *
 * @stage.name state.factory.init
 * @stage.description State factory initialization finish
 * @stage.input IStateFactory $state
 * @stage.output void
 *
 * @stage.name state.factory.after
 * @stage.description State factory destructing
 * @stage.input IStateFactory $state
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateFactory extends IItem
{
    const SUBJECT = 'state.factory';

    const STAGE__STATE_FACTORY_INIT = 'state.factory.init';
    const STAGE__STATE_FACTORY_AFTER = 'state.factory.after';

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState;
}
