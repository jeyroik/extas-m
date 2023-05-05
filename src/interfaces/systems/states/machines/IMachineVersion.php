<?php
namespace jeyroik\extas\interfaces\systems\states\machines;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IMachineVersion
 *
 * @stage.expand.type IVersion
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\machines\IVersion
 *
 * @stage.name machine.version.init
 * @stage.description Machine version initialization finish
 * @stage.input IVersion $version
 * @stage.output void
 *
 * @stage.name machine.version.after
 * @stage.description Machine version destructing
 * @stage.input IVersion $version
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
interface IMachineVersion extends IItem
{
    const SUBJECT = 'machine.version';

    const STAGE__MACHINE_VERSION_INIT = 'machine.version.init';
    const STAGE__MACHINE_VERSION_AFTER = 'machine.version.after';

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
