<?php

use jeyroik\extas\interfaces\systems\IState as State;
use jeyroik\extas\interfaces\systems\states\IStateMachine as Machine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;
use jeyroik\extas\components\systems\states\extensions\ExtensionMaxTry as EMaxTry;
use jeyroik\extas\components\systems\states\plugins\PluginStateRunNextOnFailure as POnFail;

return [
    Machine::MACHINE__CONFIG => [
        IMachineConfig::FIELD__VERSION  => '1.0',
        IMachineConfig::FIELD__ALIAS => 'primary machine',
        IMachineConfig::FIELD__START_STATE => 'app:run',
        IMachineConfig::FIELD__END_STATE => 'app:terminate',
    ],

    IMachineConfig::FIELD__STATES => [
        'app:run' => [
            State::FIELD__ID => 'app:run',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'test:to_state',
            POnFail::STATE__ON_FAILURE => 'app:failure',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],

        'test:to_state' => [
            State::FIELD__ID => 'test:to_state',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => ''
        ],
        'app:terminate' => [
            State::FIELD__ID => 'app:terminate',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \jeyroik\extas\interfaces\systems\IState
                     */
                    echo 'App termination at ' . $currentState->getId() . ' ...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => '',
        ],
        'app:failure' => [
            State::FIELD__ID => 'app:failure',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \jeyroik\extas\interfaces\systems\IState
                     */
                    echo 'App failure on "' . $currentState->getId() . '"...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => '',
        ]
    ]
];
