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
