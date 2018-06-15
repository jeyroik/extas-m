<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IStateFactory
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateFactory extends IPluginsAcceptable, IExtendable
{
    const STATE__ID = 'id';
    const STATE__DISPATCHERS = 'dispatchers';

    const STAGE__AFTER_STATE_BUILD = 'after_state_build';

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState;

    /**
     * @param $plugins
     *
     * @return bool
     */
    public static function injectPlugins($plugins);
}
