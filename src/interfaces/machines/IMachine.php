<?php
namespace extas\interfaces\machines;

use extas\interfaces\contexts\IHasContext;
use extas\interfaces\IHasDescription;
use extas\interfaces\IHasName;
use extas\interfaces\parameters\IHasParameters;
use extas\interfaces\IItem;
use extas\interfaces\contexts\IContext;

/**
 * Interface IMachine
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author jeyroik@gmail.com
 */
interface IMachine extends IItem, IHasName, IHasDescription, IHasParameters, IHasContext
{
    public const SUBJECT = 'extas.machine';

    public const FIELD__CURRENT_STATE = 'current_state';
    public const FIELD__STATES = 'states';

    public const DUMP__TO = 'state_to';
    public const DUMP__FROM = 'state_from';
    public const DUMP__CONTEXT = 'context';

    /**
     * @param string $stateName
     * @param array|IContext $context
     *
     * @return IContext
     */
    public function run(string $stateName = '', $context = null): IContext;

    /**
     * @return array
     */
    public function getDump();

    /**
     * @return string
     */
    public function getCurrentState(): string;

    /**
     * @param string $state
     * 
     * @return $this
     */
    public function setCurrentState(string $state);

    /**
     * @return array
     */
    public function getStatesConfigs(): array;

    /**
     * @param string $stateName
     *
     * @return array
     */
    public function getStateConfig($stateName): array;
}
