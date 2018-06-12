<?php

use tratabor\interfaces\systems as ISystems;
use tratabor\components\systems\states\machines\plugins as MachinePlugins;
use tratabor\interfaces\systems\states\IStateMachine as Machine;

return [
    \tratabor\interfaces\systems\IPluginsAcceptable::FIELD__PLUGINS => [
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
