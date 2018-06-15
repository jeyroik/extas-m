<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IItem
 *
 * @package jeyroik\extas\interfaces\system
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
