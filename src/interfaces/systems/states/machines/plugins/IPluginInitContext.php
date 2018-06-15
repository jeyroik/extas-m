<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Interface IPluginInitContext
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginInitContext extends IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null);
}
