<?php
namespace jeyroik\extas\interfaces\systems;

use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Interface IState
 * @package jeyroik\extas\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IState extends IItem
{
    const SUBJECT = 'state';

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
