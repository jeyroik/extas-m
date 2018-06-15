<?php
namespace tratabor\interfaces\systems;

/**
 * Interface IContainer
 *
 * @package tratabor\interfaces\systems
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
}
