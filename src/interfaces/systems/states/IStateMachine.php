<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IExtendable;
use tratabor\interfaces\systems\IPluginsAcceptable;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IStateMachine
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateMachine extends IPluginsAcceptable, IExtendable
{
    const CONTEXT__STATES = '';

    /**
     * todo mv to plugin
     */
    const CONTEXT__ERRORS = '@directive.errors()';

    const MACHINE__CONFIG = '@directive.config()';
    const MACHINE__CONFIG__VERSION = 'version';
    const MACHINE__CONFIG__ALIAS = 'alias';
    const MACHINE__CONFIG__START_STATE = 'start';
    const MACHINE__CONFIG__PLUGINS = 'machine_config__plugins';
    /**
     * For future purpose
     */
    const MACHINE__CONFIG__END_STATE = 'terminate';

    const MACHINE__STATES = '@directive.states()';

    const STAGE__BEFORE_MACHINE_INIT = 'before_machine_init';
    const STAGE__INIT_STATE_MACHINE = 'init_state_machine';
    const STAGE__INIT_CONFIG = 'init_config';
    const STAGE__INIT_CONTEXT = 'init_context';
    const STAGE__INIT_STATE_FACTORY = 'init_state_factory';
    const STAGE__BEFORE_STATE_BUILD = 'before_state_build';
    const STAGE__BEFORE_STATE_RUN = 'before_state_run';
    const STAGE__IS_STATE_VALID = 'is_state_valid';
    const STAGE__STATE_RESULT = 'state_result';
    const STAGE__NEXT_STATE = 'next_state';
    const STAGE__STATE_MACHINE_DESTRUCTED = 'state_machine_destructed';

    /**
     * IStateMachine constructor.
     *
     * @param $machineConfig
     * @param array $contextData
     */
    public function __construct($machineConfig, $contextData = []);

    /**
     * @param $stateId string
     *
     * @return mixed
     */
    public function run($stateId = null);

    /**
     * @return IState|null
     */
    public function getCurrentState();

    /**
     * @return IContext
     */
    public function getCurrentContext(): IContext;

    /**
     * @return IMachineConfig
     */
    public function getConfig(): IMachineConfig;
}
