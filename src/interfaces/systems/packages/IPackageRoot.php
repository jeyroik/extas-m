<?php
namespace jeyroik\extas\interfaces\systems\packages;

/**
 * Interface IPackageRoot
 *
 * @package jeyroik\extas\interfaces\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackageRoot
{
    /**
     * IPackageRoot constructor.
     *
     * @param $packageContent
     */
    public function __construct($packageContent);

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return array [packageName => packageContent]
     */
    public function getPackages(): array;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
