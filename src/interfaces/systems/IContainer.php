<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IContainer
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IContainer
{
    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function getItem($name);

    /**
     * @param $name string
     * @param $value
     *
     * @return mixed
     */
    public static function addItem($name, $value);

    /**
     * @return mixed
     */
    public static function reset();
}
