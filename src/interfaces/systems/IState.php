<?php
namespace tratabor\interfaces\systems;

use tratabor\interfaces\systems\states\IStateDispatcher;

/**
 * Interface IState
 * @package tratabor\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IState extends IExtendable, IPluginsAcceptable
{
    /**
     * IState constructor.
     * @param $id
     * @param $fromState
     * @param $dispatchers
     * @param array $additional
     */
    public function __construct($id, $fromState, $dispatchers = [], $additional = []);

    /**
     * @return array
     */
    public function __toArray(): array;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getFromState(): string;

    /**
     * @param string $format
     * @return mixed
     */
    public function getCreatedAt($format = '');

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
