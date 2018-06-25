<?php

use jeyroik\extas\components\systems\extensions\ExtensionRepository as Config;

use jeyroik\extas\components\systems\Context;
use jeyroik\extas\components\systems\states\extensions\ExtensionContextOnFailure;
use jeyroik\extas\components\systems\states\StatesRoute;
use jeyroik\extas\components\systems\states\StateMachine;
use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;

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
        StatesRoute::class => StatesRoute::class,
        ExtensionContextErrors::class => ExtensionContextErrors::class
    ]
];
