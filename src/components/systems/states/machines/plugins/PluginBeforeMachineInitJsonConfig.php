<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

/**
 * Class PluginInitConfigJson
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeMachineInitJsonConfig extends Plugin implements IPlugin
{
    /**
     * @param IStateMachine $machine
     * @param string $config
     *
     * @return array|mixed|null|string|\jeyroik\extas\interfaces\systems\states\machines\IMachineConfig
     */
    public function __invoke(IStateMachine &$machine, $config)
    {
        if (!is_string($config)) {
            return $config;
        }

        if (is_file($config)) {
            $fromFile = $this->__invoke($machine, file_get_contents($config));
            return is_array($fromFile)
                ? $fromFile
                : $config; // path was to not a json file
        } else {
            try {
                $decoded = json_decode($config, true);
                return $decoded;
            } catch (\Exception $e) {
                // this is not a json string
                return $config;
            }
        }
    }
}
