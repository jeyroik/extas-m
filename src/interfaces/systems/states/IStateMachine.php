<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IStateMachine
 *
 * @stage.expand.type IStateMachine
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\IStateMachine
 *
 * @stage.expand.type IState
 * @stage.expand.name jeyroik\extas\interfaces\systems\IState
 *
 * @stage.expand.type IContext
 * @stage.expand.name jeyroik\extas\interfaces\systems\IContext
 *
 * @stage.name machine.init.config
 * @stage.description Machine config initialization
 * @stage.input IStateMachine $machine, mixed $config
 * @stage.output array|IMachineConfig
 *
 * @stage.name machine.init
 * @stage.description Machine initialization finish
 * @stage.input IStateMachine &$machine
 * @stage.output void
 *
 * @stage.name machine.after
 * @stage.description Machine object destructing
 * @stage.input IStateMachine $machine
 * @stage.output void
 *
 * @stage.name state.run.before
 * @stage.description Before state running
 * @stage.input IStateMachine $machine, mixed $stateId
 * @stage.output IState $state
 *
 * @stage.name state.build.before
 * @stage.description
 * @stage.input IStateMachine $machine, mixed $stateConfig, string $fromState, string $stateId
 * @stage.output array [$stateConfig,$fromState,$stateId]
 *
 * @stage.name state.build.after
 * @stage.description After state is built
 * @stage.input IState $state
 * @stage.output IState $state
 *
 * @stage.name state.run.valid
 * @stage.description State validation before dispatching
 * @stage.input IStateMachine $machine, IState $state
 * @stage.output bool $isValid
 *
 * @stage.name state.run.after
 * @stage.description After each state dispatcher finish it work
 * @stage.input IStateMachine $machine, IContext $context
 * @stage.output bool $isContinueToTheNextDispatcher
 *
 * @stage.name state.run.next
 * @stage.description State is ran, time to choose a next state to go
 * @stage.input IStateMachine $machine, IState $state, IContext $context
 * @stage.output mixed|null $nextStateId
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
     * Stages
     */
    const STAGE__MACHINE_INIT_CONFIG = 'machine.init.config';

    const STAGE__STATE_RUN_BEFORE = 'state.run.before';
    const STAGE__STATE_BUILD_BEFORE = 'state.build.before';

    const STAGE__STATE_BUILD_AFTER = 'state.build.after';
    const STAGE__STATE_RUN_IS_VALID = 'state.run.valid';
    const STAGE__STATE_RUN_AFTER = 'state.run.after';
    const STAGE__STATE_RUN_NEXT = 'state.run.next';

    /**
     * Stages provided by parent interface
     */

    const STAGE__MACHINE_INIT = 'machine.init';
    const STAGE__MACHINE_AFTER = 'machine.after';

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
