<?php
namespace tratabor\interfaces\systems\states\machines\configs\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Interface IPluginConfigCreated
 *
 * @package tratabor\interfaces\systems\states\machines\configs\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginConfigCreated extends IPlugin
{
    public function __invoke(IMachineConfig &$config);
}
