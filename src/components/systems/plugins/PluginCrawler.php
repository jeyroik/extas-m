<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IExtension;
use jeyroik\extas\interfaces\systems\IPackage;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\IRepository;
use jeyroik\extas\interfaces\systems\packages\IPackageExtractor;
use jeyroik\extas\interfaces\systems\packages\IPackageRepository;
use jeyroik\extas\interfaces\systems\packages\IPackageRoot;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;
use jeyroik\extas\interfaces\systems\plugins\IPluginCrawler;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use tratabor\interfaces\systems\extensions\IExtensionRepository;

/**
 * Class PluginCrawler
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginCrawler implements IPluginCrawler
{
    /**
     * @var string
     */
    protected $rootPath = '';
    protected $rootPackagePath = '';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var ICrawlerPackage[]
     */
    protected $packages = [];

    /**
     * PluginCrawler constructor.
     *
     * @param string $rootPath
     * @param $config
     */
    public function __construct($rootPath = '', $config = [])
    {
        $this->setRootPath($rootPath)->setConfig($config);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function crawlPlugins(): int
    {
        if (empty($this->rootPath)) {
            throw new \Exception('Missed root path for Extas plugins crawling.');
        }

        $this->loadPackages();

        return count($this->packages);
    }

    /**
     * @return ICrawlerPackage[]
     */
    public function getPackagesInfo()
    {
        return $this->packages;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function loadPackages()
    {
        $rootPackage = $this->getRootPackage();

        if ($rootPackage->isEmpty()) {
            throw new \Exception('Empty root package "' . $this->rootPackagePath . '".');
        }

        /**
         * @var $packageStorage IRepository
         */
        $packageStorage = SystemContainer::getItem(IPackageRepository::class);

        /**
         * @var $package IPackage
         */
        $package = $this->validateRootPackage($packageStorage, $rootPackage);

        $this->grabPackages($rootPackage->getPackages());
        $package->setState(IPackage::STATE__COMMITTED);
        $packageStorage->update($package);
        $packageStorage->commit();

        return $this;
    }

    /**
     * @return IPackageRoot
     */
    protected function getRootPackage()
    {
        $rootPackageName = $this->config[static::CONFIG__PACKAGE__ROOT_NAME];
        $rootPackageExtractor = $this->config[static::CONFIG__PACKAGE__ROOT_EXTRACTOR];

        if (!is_callable($rootPackageExtractor)) {
            $rootPackageExtractor = new $rootPackageExtractor();
        }

        $this->rootPackagePath = $this->rootPath . '/' . $rootPackageName;

        return $rootPackageExtractor($this->rootPackagePath);
    }

    /**
     * @param IRepository $packageStorage
     * @param IPackageRoot $packageRoot
     *
     * @return CrawlerPackage|IPackage
     * @throws \Exception
     */
    protected function validateRootPackage($packageStorage, $packageRoot)
    {
        /**
         * @var $package IPackage
         */
        $package = $packageStorage->find([ICrawlerPackage::FIELD__NAME => $packageRoot->getName()])->one();

        if ($package->getVersion() == $packageRoot->getVersion()) {
            if ($package->getState() == IPackage::STATE__COMMITTED) {
                throw new \Exception('Packages are already crawled.');
            }
        } else {
            $package = new CrawlerPackage([
                IPackage::FIELD__ID => $packageRoot->getVersion(),
                IPackage::FIELD__NAME => $packageRoot->getName(),
                IPackage::FIELD__VERSION => $packageRoot->getVersion(),
                IPackage::FIELD__STATE => IPackage::STATE__OPERATING
            ]);
            $packageStorage->create($package);
            $packageStorage->commit();
        }

        return $package;
    }

    protected function grabPackages($packages)
    {
        /**
         * @var $storage IRepository
         */
        $storage = SystemContainer::getItem(IPluginRepository::class);
        $packageExtractor = $this->getPackageExtractor();

        foreach ($packages as $packageName => $packageInfo) {
            /**
             * @var $packageDb ICrawlerPackage
             */
            $packageDb = $storage->find([ICrawlerPackage::FIELD__NAME => $packageName])->one();

            if ($packageDb->getVersion() == $packageInfo[ICrawlerPackage::FIELD__VERSION]) {
                continue;
            }

            /**
             * @var $package ICrawlerPackage
             */
            $package = $packageExtractor(
                $this->rootPath,
                $packageInfo,
                $this->config[static::CONFIG__PACKAGE__CONFIG_NAME]
            );

            if ($package) {
                $this->packages[] = $package;
                $storage->create($packageDb);
                $this->savePlugins($package->getPlugins())->saveExtensions($package->getExtensions());
            } else {
                throw new \Exception('Can not read package info for "' . $packageName . '".');
            }
        }

        $storage->commit();

        return $this;
    }

    /**
     * @return IPackageExtractor
     */
    protected function getPackageExtractor()
    {
        $packageExtractor = $this->config[static::CONFIG__PACKAGE__EXTRACTOR];

        if (!is_callable($packageExtractor)) {
            $packageExtractor = new $packageExtractor();
        }

        return $packageExtractor;
    }

    /**
     * @param $extensions
     *
     * @return $this
     */
    protected function saveExtensions($extensions)
    {
        /**
         * @var $storage IExtensionRepository
         */
        $storage = SystemContainer::getItem(IExtensionRepository::class);

        foreach ($extensions as $extension) {
            $extensionId = $this->prepareExtensionId($extension);

            /**
             * @var $extension IExtension
             */
            $extensionDb = $storage->find([IExtension::FIELD__ID => $extensionId])->one();

            if ($extensionDb->getId() == $extensionId) {
                continue;
            }

            $extensionDb->setId($extensionId)
                ->setSubject($extension[IExtension::FIELD__SUBJECT])
                ->setClass($extension[IExtension::FIELD__CLASS])
                ->setInterface($extension[IExtension::FIELD__INTERFACE])
                ->setMethods($extension[IExtension::FIELD__METHODS]);

            $storage->create($extensionDb);
        }

        $storage->commit();

        return $this;
    }

    /**
     * @param array $extension
     *
     * @return string
     */
    protected function prepareExtensionId($extension)
    {
        return sha1(json_encode($extension));
    }

    /**
     * @param $plugins
     *
     * @return $this
     */
    protected function savePlugins($plugins)
    {
        /**
         * @var $storage IPluginRepository
         */
        $storage = SystemContainer::getItem(IPluginRepository::class);

        foreach ($plugins as $plugin) {
            $pluginId = $this->preparePluginId($plugin);

            /**
             * @var $pluginDb IPlugin
             */
            $pluginDb = $storage->find([IPlugin::FIELD__ID => $pluginId])->one();

            if ($pluginDb->getId() == $pluginId) {
                continue;
            }

            $pluginDb->setId($pluginId)
                ->setClass($plugin[IPlugin::FIELD__CLASS])
                ->setStage($plugin[IPlugin::FIELD__STAGE]);

            $storage->create($pluginDb);
        }

        $storage->commit();

        return $this;
    }

    /**
     * @param array $plugin
     *
     * @return string
     */
    protected function preparePluginId($plugin)
    {
        return sha1(json_encode($plugin));
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param $rootPath
     *
     * @return $this
     */
    protected function setRootPath($rootPath)
    {
        $this->rootPath = $rootPath;

        return $this;
    }
}
