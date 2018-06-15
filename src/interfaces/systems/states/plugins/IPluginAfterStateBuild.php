<?php
namespace jeyroik\extas\interfaces\systems\states\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\IState;

/**
 * Interface IPluginAfterStateBuild
 *
 * @package jeyroik\extas\interfaces\systems\states\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginAfterStateBuild extends IPlugin
{
    /**
     * @param IState $state
     *
     * @return IState
     */
    public function __invoke(IState $state): IState;
}
