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
     * @param array $packageInfo
     * @param string $packageConfigPath
     *
     * @return ICrawlerPackage|null
     */
    public function __invoke($packageInfo, $packageConfigPath): ICrawlerPackage;
}
