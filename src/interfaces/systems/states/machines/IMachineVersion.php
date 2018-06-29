<?php
namespace jeyroik\extas\interfaces\systems\states\machines;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IMachineVersion
 *
 * @package jeyroik\extas\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineVersion extends IItem
{
    /**
     * @return string
     */
    public function getValue();

    /**
     * @param IMachineVersion|string $version
     *
     * @return bool
     */
    public function isHigherThan($version): bool;

    /**
     * @param IMachineVersion|string $version
     *
     * @return bool
     */
    public function isLowerThan($version): bool;

    /**
     * @return bool
     */
    public function isStable(): bool;
}
