<?php
namespace extas\components\machines;

use extas\components\contexts\Context;
use extas\components\contexts\THasContext;
use extas\components\Item;
use extas\components\parameters\THasParameters;
use extas\components\machines\states\MachineState;
use extas\components\SystemContainer;
use extas\components\THasDescription;
use extas\components\THasName;
use extas\interfaces\contexts\IContext;
use extas\interfaces\machines\IMachine;
use extas\interfaces\machines\states\IMachineState;
use extas\interfaces\machines\states\IMachineStateRepository;

/**
 * Class StateMachine
 *
 * @package jeyroik\extas\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class Machine extends Item implements IMachine
{
    use THasName;
    use THasDescription;
    use THasParameters;
    use THasContext;

    /**
     * @var IMachineState|null
     */
    protected ?IMachineState $currentState = null;
    protected array $statesByName = [];

    protected array $dump = [];

    /**
     * @param string $stateName
     * @param array|IContext $context
     *
     * @throws \Exception
     * @return IContext
     */
    public function run(string $stateName = '', $context = null): IContext
    {
        $context = $context instanceof IContext ? $context : new Context($context);

        if ($this->hasState($stateName)) {
            $state = $this->buildState($this->getStateConfig($stateName), $stateName, $context);

            if ($this->isStateValid($state, $context)) {
                $isSuccess = $this->runState($state, $context);
                $transition = $isSuccess ? $state->getOnSuccess() : $state->getOnFailure();

                if ($transition->isEmpty()) {
                    return $context;
                } else {
                    $machine = $transition->hasMachine() ? $transition->getMachine() : $this;
                    $result = $machine->run($transition->getState(), $context);
                    if ($machine->getName() != $this->getName()) {
                        $this->mergeDump($machine->getDump());
                    }
                    return $result;
                }
            } else {
                throw new \Exception('State "' . $stateName . '" is invalid');
            }
        } else {
            throw new \Exception('Unknown state "' . $stateName . '"');
        }
    }

    /**
     * @return array
     */
    public function getDump()
    {
        return $this->dump;
    }

    /**
     * @param $dump
     */
    protected function mergeDump($dump)
    {
        $this->dump = array_merge($this->dump, $dump);
    }

    /**
     * @param string $stateName
     *
     * @return bool
     */
    protected function hasState($stateName): bool
    {
        $stateConfig = $this->getStateConfig($stateName);

        return !empty($stateConfig);
    }

    /**
     * @param IMachineState $state
     * @param IContext $context
     *
     * @return bool
     * @throws \Exception
     */
    protected function runState($state, $context)
    {
        $isSuccess = true;

        $stage = 'machine.to.state';
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $plugin($state, $context, $this, $isSuccess);
        }

        $stage = $this->getName() . '.to.' . $state->getName();
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $plugin($state, $context, $this, $isSuccess);
        }

        return $isSuccess;
    }

    /**
     * @param $stateConfig
     * @param $stateName
     * @param $context
     *
     * @return IMachineState
     * @throws
     */
    protected function buildState($stateConfig, $stateName, &$context)
    {
        /**
         * @var $stateRepo IMachineStateRepository
         * @var $state IMachineState
         */
        $stateRepo = SystemContainer::getItem(IMachineStateRepository::class);
        $state = $stateRepo->one([IMachineState::FIELD__NAME => $stateName]);
        if (!$state) {
            throw new \Exception('Unknown state "' . $stateName . '"');
        }

        $state = new MachineState(array_merge($state->__toArray(), $stateConfig));

        if (isset($context[IMachineState::FIELD__FROM_STATE]) && $context[IMachineState::FIELD__FROM_STATE]) {
            $fromState = $context[IMachineState::FIELD__FROM_STATE];
        } else {
            $fromState = $this->getCurrentState();
            $context[IMachineState::FIELD__FROM_STATE] = $fromState;
            /**
             * Исходим из того, что если в контексте нет исходного состояния, то машина запускается "с начала".
             */
            $this->dump = [];
        }

        $this->addToDump($state->getName(), $context);
        $state->setFromState($fromState);
        $this->setCurrentState($state->getName());

        return $state;
    }

    /**
     * @param string $stateName
     * @param IContext $context
     *
     * @return $this
     */
    protected function addToDump($stateName, $context)
    {
        $this->dump[] = [
            static::DUMP__FROM => $this->getName() . '.' . $this->getCurrentState(),
            static::DUMP__TO => $this->getName() . '.' . $stateName,
            static::DUMP__CONTEXT => $context->__toArray()
        ];

        return $this;
    }

    /**
     * @param IMachineState $state
     * @param IContext $context
     *
     * @return bool
     */
    protected function isStateValid($state, $context): bool
    {
        $isValid = true;

        $stateParams = $state->getParameters(true);
        $machineParameters = $this->getParameters(true);
        $state->setParameters(array_merge($stateParams, $machineParameters));

        $stage = 'machine.state.validation';
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $plugin($state, $context, $isValid, $this);
        }

        $stage = $this->getName() . '.machine.state.validation';
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $plugin($state, $context, $isValid, $this);
        }

        $stage = $this->getName() . '.to.' . $state->getName() . '.validation';
        foreach ($this->getPluginsByStage($stage) as $plugin) {
            $plugin($state, $context, $isValid, $this);
        }

        return (bool) $isValid;
    }

    /**
     * @return string
     */
    public function getCurrentState(): string
    {
        return $this->config[static::FIELD__CURRENT_STATE] ?? '';
    }

    /**
     * @return array
     */
    public function getStatesConfigs(): array
    {
        return $this->config[static::FIELD__STATES] ?? [];
    }

    /**
     * @param string $stateName
     *
     * @return array
     */
    public function getStateConfig($stateName): array
    {
        if (empty($this->statesByName)) {
            $this->statesByName = array_column(
                $this->getStatesConfigs(),
                null,
                IMachineState::FIELD__NAME
            );
        }

        return $this->statesByName[$stateName] ?? [];
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setCurrentState(string $state)
    {
        $this->config[static::FIELD__CURRENT_STATE] = $state;

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
