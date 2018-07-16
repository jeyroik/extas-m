<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPackage
 *
 * @stage.expand.type IPackage
 * @stage.expand.name jeyroik\extas\interfaces\systems\IPackage
 *
 * @stage.name package.init
 * @stage.description Package initialization finish
 * @stage.input IPackage
 * @stage.output void
 *
 * @stage.name package.after
 * @stage.description Package destructing
 * @stage.input IPackage
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackage extends IItem
{
    const SUBJECT = 'package';

    const STAGE__PACKAGE_INIT = 'package.init';
    const STAGE__PACKAGE_AFTER = 'package.after';

    const FIELD__NAME = 'name';
    const FIELD__DESCRIPTION = 'description';
    const FIELD__VERSION = 'version';
    const FIELD__STATE = 'state';
    const FIELD__ID = 'id';

    const STATE__OPERATING = 'operating';
    const STATE__COMMITTED = 'committed';

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getState(): string;

    /**
     * @param $state
     *
     * @return $this
     */
    public function setState($state);

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name);

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description);

    /**
     * @param $version
     *
     * @return $this
     */
    public function setVersion($version);
}
