<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IItem
 *
 * @package jeyroik\extas\interfaces\system
 * @author Funcraft <me@funcraft.ru>
 */
interface IItem extends \ArrayAccess, \Iterator, IPluginsAcceptable, IExtendable
{
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
     * @return array
     */
    public function __toArray(): array;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return int
     */
    public function __toInt(): int;

    /**
     * @param $item
     *
     * @return $this
     */
    public function __saved($item);
}
