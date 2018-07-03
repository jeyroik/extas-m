<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\interfaces\systems\packages\IPackageExtractor;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class PackageExtractorJson
 *
 * @package jeyroik\extas\components\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
class PackageExtractorJson implements IPackageExtractor
{
    /**
     * @param string $rootPath
     * @param array $packageInfo
     * @param string $packageConfigName
     *
     * @return ICrawlerPackage
     */
    public function __invoke($rootPath, $packageInfo, $packageConfigName): ICrawlerPackage
    {
        $fullPath = $rootPath . '/*/' . $packageInfo[ICrawlerPackage::FIELD__NAME] . '/' . $packageConfigName;
        $finder = new Finder();
        $finder->name($fullPath);

        foreach ($finder->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            $packageConfig = json_decode($file->getContents(), true);
            $package = new CrawlerPackage([
                ICrawlerPackage::FIELD__ID => sha1(json_encode($packageConfig)),
                ICrawlerPackage::FIELD__NAME => $packageInfo[ICrawlerPackage::FIELD__NAME],
                ICrawlerPackage::FIELD__TITLE => $packageConfig[ICrawlerPackage::FIELD__TITLE],
                ICrawlerPackage::FIELD__PLUGINS => $packageConfig[ICrawlerPackage::FIELD__PLUGINS],
                ICrawlerPackage::FIELD__EXTENSIONS => $packageConfig[ICrawlerPackage::FIELD__EXTENSIONS],
                ICrawlerPackage::FIELD__VERSION => $packageInfo[ICrawlerPackage::FIELD__VERSION],
                ICrawlerPackage::FIELD__DESCRIPTION => $packageInfo[ICrawlerPackage::FIELD__DESCRIPTION]
            ]);

            return $package;
        }

        return null;
    }
}
