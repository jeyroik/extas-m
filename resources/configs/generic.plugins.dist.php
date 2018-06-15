<?php

use jeyroik\extas\interfaces\systems as ISystems;
use jeyroik\extas\components\systems\states\machines\plugins as MachinePlugins;
use jeyroik\extas\interfaces\systems\states\IStateMachine as Machine;

return [
    \jeyroik\extas\interfaces\systems\IPluginsAcceptable::FIELD__PLUGINS => [
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeMachineInitPhpConfig::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_MACHINE_INIT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeMachineInitJsonConfig::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_MACHINE_INIT
        ]
    ]
];
