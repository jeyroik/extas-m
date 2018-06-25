<?php

use jeyroik\extas\components\systems\extensions\ExtensionRepository as Config;

use jeyroik\extas\components\systems\Context;
use jeyroik\extas\components\systems\states\extensions\ExtensionContextOnFailure;
use jeyroik\extas\components\systems\states\StatesRoute;
use jeyroik\extas\components\systems\states\StateMachine;
use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;
use jeyroik\extas\interfaces\systems as ISystems;
use jeyroik\extas\components\systems\states\plugins as StatesPlugins;

return [
    Config::CONFIG__METHODS => [
        StateMachine::class => [
            'from' => StatesRoute::class,
            'to' => StatesRoute::class,
            'getRoute' => StatesRoute::class,
            'setRoute' => StatesRoute::class,
            'getCurrentFrom' => StatesRoute::class,
            'getCurrentTo' => StatesRoute::class
        ],
        Context::class => [
            'setSuccess' => ExtensionContextOnFailure::class,
            'setFail' => ExtensionContextOnFailure::class,
            'addError' => ExtensionContextErrors::class
        ]
    ],

    Config::CONFIG__IMPLEMENTATIONS => [
        ExtensionContextOnFailure::class => ExtensionContextOnFailure::class,
        StatesRoute::class => [
            Config::CONFIG__CLASS => StatesRoute::class,
            Config::CONFIG__ARGUMENTS => [
                ISystems\IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID => ISystems\states\IStatesRoute::class,
                ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
                    [
                        ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginRouteFromStart::class,
                        ISystems\IPlugin::FIELD__VERSION => '1.0',
                        ISystems\IPlugin::FIELD__STAGE => ISystems\states\IStatesRoute::STAGE__FROM
                    ],
                    [
                        ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginRouteToPath::class,
                        ISystems\IPlugin::FIELD__VERSION => '1.0',
                        ISystems\IPlugin::FIELD__STAGE => ISystems\states\IStatesRoute::STAGE__TO
                    ]
                ]
            ]
        ],
        ExtensionContextErrors::class => ExtensionContextErrors::class
    ]
];
