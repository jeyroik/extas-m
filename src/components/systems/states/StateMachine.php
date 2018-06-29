<?php
namespace jeyroik\extas\components\systems\states;

use jeyroik\extas\components\systems\Context;
use jeyroik\extas\components\systems\Item;
use jeyroik\extas\components\systems\states\machines\MachineConfig;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateFactory;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Class StateMachine
 *
 * @package jeyroik\extas\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateMachine extends Item implements IStateMachine
{
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
    protected $machineConfig = [];

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
        $this->initConfig($machineConfig)
            ->initStateFactory()
            ->initContext($contextData);

        parent::__construct($machineConfig);
    }

    /**
     * @param string $stateId
     *
     * @throws \Exception
     * @return string
     */
    public function run($stateId = null)
    {
        foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_RUN_BEFORE) as $plugin) {
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
        return $this->machineConfig;
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
        $stateConfig = $this->machineConfig->getStateConfig($stateId);
        $fromState = $this->currentState ? $this->currentState->getId() : '';

        foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_BUILD_BEFORE) as $plugin) {
            list($stateConfig, $fromState, $stateId) = $plugin($this, $stateConfig, $fromState, $stateId);
        }

        $state = $this->stateFactory::buildState($stateConfig, $fromState, $stateId);

        foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_BUILD_AFTER) as $plugin) {
            $state = $plugin($state);
        }

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
        foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_RUN_IS_VALID) as $plugin) {
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

        foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_RUN_NEXT) as $plugin) {
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

            foreach ($this->getPluginsByStage(IStateMachine::STAGE__STATE_RUN_AFTER) as $plugin) {
                if (!$plugin($this, $this->currentContext)) {
                    break 2;
                }
            }
        }

        return $this;
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function initConfig($config)
    {
        foreach ($this->getPluginsByStage(IStateMachine::STAGE__MACHINE_INIT_CONFIG) as $plugin) {
            $config = $plugin($this, $config);
        }

        $this->machineConfig = new MachineConfig($config);

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

        return $this;
    }

    /**
     * @return $this
     */
    protected function initStateFactory()
    {
        $this->stateFactory = SystemContainer::getItem(IStateFactory::class);

        return $this;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
