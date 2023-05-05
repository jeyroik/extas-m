<?php
namespace jeyroik\extas\interfaces\systems\packages;

/**
 * Interface IPackageRootExtractor
 *
 * @package jeyroik\extas\interfaces\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackageRootExtractor
{
    /**
     * @param $rootPackagePath
     *
     * @return IPackageRoot
     */
    public function __invoke($rootPackagePath): IPackageRoot;
}
