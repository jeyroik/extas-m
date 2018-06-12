<?php
namespace tratabor\interfaces\systems\states\machines\plugins;

use tratabor\interfaces\systems\IPlugin;

/**
 * Interface IPluginValidation
 *
 * @package tratabor\interfaces\systems\states\machines\plugins
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
