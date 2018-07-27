<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IExtendable
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtendable
{
    const STAGE__EXTENDED_METHOD_CALL = 'extension___method_call';

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function isImplementsInterface(string $interface): bool;
}
