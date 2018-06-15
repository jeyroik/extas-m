<?php
namespace jeyroik\extas\interfaces\systems\states\machines;

use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IPluginsAcceptable;

/**
 * Interface IMachineConfig
 *
 * @package jeyroik\extas\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineConfig extends \ArrayAccess, \Iterator, IPluginsAcceptable, IExtendable
{
    const FIELD__ALIAS = 'alias';
    const FIELD__VERSION = 'version';
    const FIELD__START_STATE = 'start_state';
    const FIELD__END_STATE = 'end_state';
    const FIELD__STATES = 'states';

    const STAGE__ON_PROPERTY_SET = 'machine_config__on_property_set';
    const STAGE__ON_PROPERTY_GET = 'machine_config__on_property_get';
    const STAGE__CREATED = 'machine_config__created';
    const STAGE__DESTRUCTED = 'machine_config__destructed';

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
     * @return mixed
     */
    public function getMachinePluginsList();

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
