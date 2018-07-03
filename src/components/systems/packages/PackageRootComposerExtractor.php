<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\interfaces\systems\packages\IPackageRoot;
use jeyroik\extas\interfaces\systems\packages\IPackageRootExtractor;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class PackageRootComposerExtractor
 *
 * @package jeyroik\extas\components\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
class PackageRootComposerExtractor implements IPackageRootExtractor
{
    /**
     * @param $rootPackagePath
     *
     * @return IPackageRoot
     */
    public function __invoke($rootPackagePath): IPackageRoot
    {
        $finder = new Finder();
        $finder->name($rootPackagePath);
        $rootPackage = [];

        foreach ($finder->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            $rootPackage = json_decode($file->getContents(), true);
            break;
        }

        return new PackageRootComposer($rootPackage);
    }
}