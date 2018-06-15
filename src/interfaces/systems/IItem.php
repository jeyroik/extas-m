<?php
namespace tratabor\interfaces\systems;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;

/**
 * Interface IItem
 * @package tratabor\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IItem
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @param $value
     *
     * @return IItem
     */
    public function setValue($value);

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param string $format
     *
     * @return string|int
     */
    public function getCreatedAt($format = '');

    /**
     * @param string $format
     *
     * @return string|int
     */
    public function getUpdatedAt($format = '');

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return array
     */
    public function __toArray(): array;
}
