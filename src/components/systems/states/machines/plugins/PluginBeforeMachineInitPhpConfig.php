<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\components\systems\Plugin;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeMachineInit;

/**
 * Class PluginInitConfigPhp
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeMachineInitPhpConfig extends Plugin implements IPluginBeforeMachineInit
{
    /**
     * @param IStateMachine $machine
     * @param mixed $config
     *
     * @return mixed
     */
    public function __invoke(IStateMachine &$machine, $config)
    {
        if (is_string($config)) {
            /**
             * May be it is a path?
             */
            if (is_file($config)) {
                $phpConfig = include $config;

                if (is_array($phpConfig)) {
                    $config = $phpConfig;
                }
            }
        }

        return $config;
    }
}
