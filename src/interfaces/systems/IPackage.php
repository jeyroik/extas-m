<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPackage
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackage extends IItem
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $name
     *
     * @return array
     */
    public function getRequire($name = '');

    /**
     * @param string $name
     *
     * @return array
     */
    public function getProduce($name = '');

    /**
     * @param string $field
     *
     * @return mixed
     */
    public function getCodePackage($field = '');
}
