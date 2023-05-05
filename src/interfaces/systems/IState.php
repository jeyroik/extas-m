<?php
namespace jeyroik\extas\interfaces\systems;

use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Interface IState
 *
 * @stage.expand.type IState
 * @stage.expand.name jeyroik\extas\interfaces\systems\IState
 *
 * @stage.name state.init
 * @stage.description State initialization finish
 * @stage.input IState $state
 * @stage.output void
 *
 * @stage.name state.after
 * @stage.description State destructing
 * @stage.input IState $state
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IState extends IItem
{
    const SUBJECT = 'state';

    const STAGE__STATE_INIT = 'state.init';
    const STAGE__STATE_AFTER = 'state.after';

    const FIELD__ID = 'id';
    const FIELD__FROM_STATE = 'from_state';
    const FIELD__DISPATCHERS = 'dispatchers';
    const FIELD__ADDITIONAL = 'additional';

    /**
     * IState constructor.
     * @param $id
     * @param $fromState
     * @param $dispatchers
     * @param array $additional
     */
    public function __construct($id, $fromState = '', $dispatchers = [], $additional = []);

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getFromState(): string;

    /**
     * @return IStateDispatcher[]
     */
    public function getDispatchers();

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getAdditional($name = '', $default = null);

    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function setAdditional($name, $value);
}
