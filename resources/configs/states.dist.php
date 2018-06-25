<?php

use jeyroik\extas\interfaces\systems\states\IStateFactory as State;
use jeyroik\extas\interfaces\systems\states\IStateMachine as Machine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitConfigStatePlugins as PStatePlugins;
use jeyroik\extas\interfaces\systems as ISystems;
use jeyroik\extas\components\systems\states\plugins as StatesPlugins;
use jeyroik\extas\components\systems\states\machines\plugins as MachinePlugins;
use jeyroik\extas\components\systems\states\plugins\ExtensionMaxTry as EMaxTry;
use jeyroik\extas\components\systems\states\plugins\PluginNextStateOnFailure as POnFail;

/**
 * README
 *
 * Plugin definition:
 * [
 *      ISystems\IPlugin::FIELD__CLASS => <full class name>,
 *      ISystems\IPlugin::FIELD__VERSION => '1.0', // or any other version
 *      ISystems\IPlugin::FIELD__STAGE => <stage name>
 * ]
 */

return [
    Machine::MACHINE__CONFIG => [
        IMachineConfig::FIELD__VERSION  => '1.0',
        IMachineConfig::FIELD__ALIAS => 'primary machine',
        IMachineConfig::FIELD__START_STATE => 'app:run',
        IMachineConfig::FIELD__END_STATE => 'app:terminate',

        ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
            /**
             * Plugins for the current machine config.
             * [
             *      ISystems\IPlugin::FIELD__CLASS => <full class name>,
             *      ISystems\IPlugin::FIELD__VERSION => '1.0', // or any other version
             *      ISystems\IPlugin::FIELD__STAGE => <stage name>
             * ]
             */
        ],

        PStatePlugins::MACHINE__STATE_PLUGINS => [
            /**
             * Plugins for each state.
             * Current option is ignoring if state has own plugins definition.
             */
        ]
    ],

    ISystems\IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID => 'default_machine',
    ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
        /**
         * Plugins for the current machine.
         */
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginInitContextSuccess::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__INIT_CONTEXT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunCycle::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunExistingState::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunStart::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunTheEnd::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateResultOnFailure::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RESULT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginBeforeStateBuildGuaranteeStateId::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_BUILD
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginBeforeStateBuildErrorState::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_BUILD
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginIsStateValidMaxTry::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__IS_STATE_VALID
        ]
    ],

    Machine::MACHINE__STATES => [
        'app:run' => [
            State::STATE__ID => 'app:run',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'test:to_state',
            POnFail::STATE__ON_FAILURE => 'app:failure',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],

        'test:to_state' => [
            State::STATE__ID => 'test:to_state',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => ''
        ],
        'app:terminate' => [
            State::STATE__ID => 'app:terminate',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
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
            State::STATE__ID => 'app:failure',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
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
