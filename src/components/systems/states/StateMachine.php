<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\Context;
use tratabor\components\systems\extensions\TExtendable;
use tratabor\components\systems\plugins\TPluginAcceptable;
use tratabor\components\systems\states\machines\MachineConfig;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\plugins\IPluginRepository;
use tratabor\interfaces\systems\states\IStateFactory;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Class StateMachine
 *
 * @sm-stage-interface before_state_run(IStateMachine $machine, string $stateId): string stateId
 * @sm-stage-interface before_state_build(
 *      IStateMachine $machine,
 *      array $stateConfig,
 *      string $fromState,
 *      string $stateId
 *  ): array [array $stateConfig, string $fromState, string $stateId]
 * @sm-stage-interface is_state_valid(IStateMachine $machine, IState $state): bool
 * @sm-stage-interface next_state(IStateMachine $machine, IState $state, IContext $currentContext): string next state id
 * @sm-stage-interface state_result(
 *      IStateMachine $machine,
 *      IContext $currentContext
 * ): bool is valid result, continue dispatching?
 * @sm-stage-interface init_config(IStateMachine, IMachineConfig $config): IMachineConfig
 * @sm-stage-interface init_context(IStateMachine $machine, IContext $context): IContext
 * @sm-stage-interface init_state_factory(IStateMachine $machine, IStateFactory $factory): IStateFactory
 * @sm-stage-interface init_machine(IStateMachine &$machine): IStateMachine
 * @sm-stage-interface state_machine_destructed(IStateMachine &$machine)
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateMachine implements IStateMachine
{
    use TPluginAcceptable;
    use TExtendable;

    /**
     * key   = stateId
     * value = tries count
     *
     * @var array
     */
    protected $states = [];

    /**
     * @var IMachineConfig
     */
    protected $config = [];

    /**
     * @var IContext
     */
    protected $currentContext = null;

    /**
     * @var IState
     */
    protected $currentState = null;

    /**
     * @var IStateFactory
     */
    protected $stateFactory = null;

    /**
     * StateMachine constructor.
     *
     * @param $machineConfig
     * @param array $contextData
     */
    public function __construct($machineConfig, $contextData = [])
    {
        $this->setConfig($machineConfig)
            ->registerPlugins($this->config->getMachinePluginsList())
            ->initConfig()
            ->initStateFactory()
            ->initMachine()
            ->initContext($contextData);
    }

    public function __destruct()
    {
        foreach ($this->findPluginsByStage(IStateMachine::STAGE__STATE_MACHINE_DESTRUCTED) as $plugin) {
            $plugin($this);
        }
    }

    /**
     * @param string $stateId
     *
     * @throws \Exception
     * @return string
     */
    public function run($stateId = null)
    {
        foreach ($this->findPluginsByStage(IStateMachine::STAGE__BEFORE_STATE_RUN) as $plugin) {
            $stateId = $plugin($this, $stateId);
        }
        $state = $this->buildState($stateId);

        return $this->runState($state);
    }

    /**
     * @return IState|null
     */
    public function getCurrentState()
    {
        return $this->currentState;
    }

    /**
     * @return IMachineConfig
     */
    public function getConfig(): IMachineConfig
    {
        return $this->config;
    }

    /**
     * @return IContext
     */
    public function getCurrentContext(): IContext
    {
        return $this->currentContext;
    }

    /**
     * @param $stateId
     *
     * @return IState
     */
    protected function buildState($stateId)
    {
        $stateConfig = $this->config->getStateConfig($stateId);
        $fromState = $this->currentState ? $this->currentState->getId() : '';

        foreach ($this->findPluginsByStage(IStateMachine::STAGE__BEFORE_STATE_BUILD) as $plugin) {
            list($stateConfig, $fromState, $stateId) = $plugin($this, $stateConfig, $fromState, $stateId);
        }

        $state = $this->stateFactory::buildState($stateConfig, $fromState, $stateId);
        $this->currentState = $state;

        return $state;
    }

    /**
     * @param IState $state
     *
     * @return string
     */
    protected function runState($state)
    {
        foreach ($this->findPluginsByStage(IStateMachine::STAGE__IS_STATE_VALID) as $plugin) {
            $isValidState = $plugin($this, $state);

            if ($isValidState) {
                $state = $plugin->onValid($state);
                continue;
            } else {
                $nextStateId = $plugin->onInvalid($state);
                return $nextStateId ? $this->run($nextStateId) : '';
            }
        }

        $this->runStateDispatchers($state);

        foreach ($this->findPluginsByStage(IStateMachine::STAGE__NEXT_STATE) as $plugin) {
            $nextStateId = $plugin($this, $state, $this->currentContext);

            if ($nextStateId) {
                return $this->run($nextStateId);
            }
        }

        return $this->currentState->getId();
    }

    /**
     * @param IState $state
     *
     * @return $this
     */
    protected function runStateDispatchers($state)
    {
        foreach ($state->getDispatchers() as $dispatcher) {
            $this->currentContext = $dispatcher($state, $this->currentContext);

            foreach ($this->findPluginsByStage(IStateMachine::STAGE__STATE_RESULT) as $plugin) {
                if (!$plugin($this, $this->currentContext)) {
                    break 2;
                }
            }
        }

        return $this;
    }

    /**
     * @param string $stage
     *
     * @return \Generator|IPlugin
     */
    protected function findPluginsByStage($stage)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage($this, $stage) as $plugin) {
            yield $plugin;
        }
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function setConfig($config)
    {
        /**
         * Chicken or egg problem solving
         */

        $genericPluginsPath = getenv('SM__GENERIC_PLUGINS_PATH')
            ?? EXTASM__ROOT_PATH . '/resources/configs/generic.plugins.php';

        if (is_file($genericPluginsPath)) {
            $genericPlugins = include $genericPluginsPath;
            $this->registerPlugins($genericPlugins);
        }

        foreach ($this->findPluginsByStage(IStateMachine::STAGE__BEFORE_MACHINE_INIT) as $plugin) {
            $config = $plugin($this, $config);
        }

        $this->config = new MachineConfig($config);

        return $this;
    }

    /**
     * @return $this
     */
    protected function initConfig()
    {
        foreach ($this->findPluginsByStage(IStateMachine::STAGE__INIT_CONFIG) as $plugin) {
            $this->config = $plugin($this, $this->config);
        }

        return $this;
    }

    /**
     * @param $contextData
     *
     * @return $this
     */
    protected function initContext($contextData)
    {
        $this->currentContext = new Context($contextData);

        foreach ($this->findPluginsByStage(IStateMachine::STAGE__INIT_CONTEXT) as $plugin) {
            $this->currentContext = $plugin($this, $this->currentContext);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initStateFactory()
    {
        $this->stateFactory = SystemContainer::getItem(IStateFactory::class);

        foreach ($this->findPluginsByStage(IStateMachine::STAGE__INIT_STATE_FACTORY) as $plugin) {
            $this->stateFactory = $plugin($this, $this->stateFactory);
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initMachine()
    {
        foreach ($this->findPluginsByStage(IStateMachine::STAGE__INIT_STATE_MACHINE) as $plugin) {
            $plugin($this);
        }

        return $this;
    }
}
