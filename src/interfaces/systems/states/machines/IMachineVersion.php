<?php
namespace tratabor\interfaces\systems\states\machines;

/**
 * Interface IMachineVersion
 *
 * @package tratabor\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineVersion
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
