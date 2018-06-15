<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginIsApplicableState
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginBeforeStateRun extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     */
    public function __invoke(IStateMachine $machine, $stateId = '');
}
