<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginNextState
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginNextState extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IState|null $currentState
     * @param IContext|null $context
     *
     * @return string|false return false if you can not advice next state
     */
    public function __invoke(IStateMachine $machine, IState $currentState = null, IContext $context = null);
}
