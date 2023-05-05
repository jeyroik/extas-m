<?php
namespace jeyroik\extas\interfaces\systems\states\machines;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;

/**
 * Interface IMachineConfig
 *
 * @stage.expand.type IConfig
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\machines\IMachineConfig
 *
 * @stage.name machine.config.init
 * @stage.description Machine config initialization finish
 * @stage.input IConfig $config
 * @stage.output void
 *
 * @stage.name machine.config.after
 * @stage.description Machine config destructing
 * @stage.input IConfig $config
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineConfig extends IItem
{
    const SUBJECT = 'machine.config';

    const STAGE__MACHINE_CONFIG_INIT = 'machine.config.init';
    const STAGE__MACHINE_CONFIG_AFTER = 'machine.config.after';

    const FIELD__ALIAS = 'alias';
    const FIELD__VERSION = 'version';
    const FIELD__START_STATE = 'start_state';
    const FIELD__END_STATE = 'end_state';
    const FIELD__STATES = 'states';

    const STAGE__ON_PROPERTY_SET = 'machine.config.property.set';
    const STAGE__ON_PROPERTY_GET = 'machine.config.property.get';

    /**
     * @return IMachineVersion
     */
    public function getVersion();

    /**
     * @return string
     */
    public function getAlias(): string;

    /**
     * @return string
     */
    public function getStartState(): string;

    /**
     * @return string
     */
    public function getEndState(): string;

    /**
     * @param $stateId
     *
     * @return mixed
     */
    public function getStateConfig($stateId);

    /**
     * @param $stateId
     *
     * @return bool
     */
    public function hasState($stateId): bool;

    /**
     * @return array
     */
    public function getStatesConfig();

    /**
     * @param $stateId
     * @param $stateConfig
     *
     * @return $this
     */
    public function setState($stateId, $stateConfig);
}
