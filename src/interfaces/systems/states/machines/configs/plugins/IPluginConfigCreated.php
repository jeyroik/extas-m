<?php
namespace jeyroik\extas\interfaces\systems\states\machines\configs\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginConfigCreated
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\configs\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginConfigCreated extends IPlugin
{
    public function __invoke(IMachineConfig &$config);
}
