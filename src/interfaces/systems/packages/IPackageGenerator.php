<?php
namespace jeyroik\extas\interfaces\systems\packages;

/**
 * Interface IPackageGenerator
 *
 * @package jeyroik\extas\interfaces\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackageGenerator
{
    /**
     * IPackageGenerator constructor.
     *
     * @param $whereToSearch
     * @param $whereToPut
     * @param $configName
     */
    public function __construct($whereToSearch, $whereToPut, $configName);

    /**
     * @return bool
     */
    public function generate(): bool;
}
