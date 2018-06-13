<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IExtendable;
use tratabor\interfaces\systems\IPluginsAcceptable;
use tratabor\interfaces\systems\IState;

/**
 * Interface IStateFactory
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateFactory extends IPluginsAcceptable, IExtendable
{
    const STATE__ID = 'id';
    const STATE__MAX_TRY = 'max_try';
    const STATE__DISPATCHERS = 'dispatchers';
    const STATE__ON_SUCCESS = 'on_success';
    const STATE__ON_FAILURE = 'on_failure';
    const STATE__ON_TERMINATE = 'on_terminate';

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
