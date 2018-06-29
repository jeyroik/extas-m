<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IStateMachine
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateMachine extends IItem
{
    const SUBJECT = 'machine';

    const MACHINE__CONFIG = '@directive.config()';
    const MACHINE__CONFIG__VERSION = 'version';
    const MACHINE__CONFIG__ALIAS = 'alias';
    const MACHINE__CONFIG__START_STATE = 'start';
    const MACHINE__CONFIG__END_STATE = 'terminate';

    const MACHINE__STATES = '@directive.states()';

    /**
     * @deprecated use INIT_MACHINE
     */
    const STAGE__BEFORE_MACHINE_INIT = 'before_machine_init';

    const STAGE__MACHINE_INIT_CONFIG = 'machine.init.config';
    const STAGE__MACHINE_INIT_MACHINE = 'machine.init.machine';
    const STAGE__MACHINE_INIT_CONTEXT = 'machine.init.context';
    const STAGE__MACHINE_INIT_FACTORY_STATE = 'machine.init.factory.state';
    const STAGE__MACHINE_AFTER = 'machine.after';

    const STAGE__STATE_RUN_BEFORE = 'state.run.before';
    const STAGE__STATE_BUILD_BEFORE = 'state.build.before';
    const STAGE__STATE_INIT = 'state.init';
    const STAGE__STATE_AFTER = 'state.after';
    const STAGE__STATE_BUILD_AFTER = 'state.build.after';
    const STAGE__STATE_RUN_IS_VALID = 'state.run.valid';
    const STAGE__STATE_RUN_AFTER = 'state.run.after';
    const STAGE__STATE_RUN_NEXT = 'state.run.next';

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
