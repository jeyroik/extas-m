<?php
namespace jeyroik\extas\interfaces\systems\packages;

use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;

/**
 * Interface IPackageExtractor
 *
 * @package jeyroik\extas\interfaces\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
interface IPackageExtractor
{
    /**
     * @param string $rootPath
     * @param array $packageInfo
     * @param string $packageConfigName
     *
     * @return ICrawlerPackage|null
     */
    public function __invoke($rootPath, $packageInfo, $packageConfigName);

    public function extract
}
