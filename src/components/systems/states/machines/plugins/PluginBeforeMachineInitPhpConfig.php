<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Class PluginInitConfigPhp
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeMachineInitPhpConfig extends Plugin implements IPlugin
{
    public $preDefinedStage = IStateMachine::STAGE__MACHINE_INIT_CONFIG;

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
