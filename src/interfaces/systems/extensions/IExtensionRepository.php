<?php
namespace tratabor\interfaces\systems\extensions;

use jeyroik\extas\interfaces\systems\IExtension;

/**
 * Interface IExtensionRepository
 *
 * @package tratabor\interfaces\systems\states\extensions
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtensionRepository
{
    /**
     * @param $subject
     * @param $interface
     * @param $interfaceImplementation
     * @param array $methods
     *
     * @return bool
     */
    public static function addExtension($subject, $interface, $interfaceImplementation, $methods = []): bool;

    /**
     * @param $subject
     * @param $method
     *
     * @return IExtension|string
     */
    public static function getExtension($subject, $method);

    /**
     * @param $interface
     *
     * @return bool
     */
    public static function hasInterfaceImplementation($interface): bool;
}
