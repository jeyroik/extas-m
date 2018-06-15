<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateFactory;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginInitStateFactory
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitStateFactory extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IStateFactory $stateFactory
     *
     * @return IStateFactory
     */
    public function __invoke(IStateMachine $machine, $stateFactory = null);
}
