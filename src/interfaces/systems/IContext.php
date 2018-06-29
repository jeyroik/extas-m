<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IContext
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IContext extends IItem
{
    const SUBJECT = 'context';

    /**
     * @param string $name
     *
     * @return IContext
     */
    public function setReadOnly($name);
}
