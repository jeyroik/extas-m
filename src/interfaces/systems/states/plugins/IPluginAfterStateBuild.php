<?php
namespace tratabor\interfaces\systems\states\plugins;

use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\IState;

/**
 * Interface IPluginAfterStateBuild
 *
 * @package tratabor\interfaces\systems\states\plugins
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
