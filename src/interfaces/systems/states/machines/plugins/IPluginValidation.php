<?php
namespace jeyroik\extas\interfaces\systems\states\machines\plugins;

use jeyroik\extas\interfaces\systems\IPlugin;

/**
 * Interface IPluginValidation
 *
 * @package jeyroik\extas\interfaces\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginValidation extends IPlugin
{
    /**
     * @return mixed
     */
    public function onValid();

    /**
     * @return mixed
     */
    public function onInvalid();
}
