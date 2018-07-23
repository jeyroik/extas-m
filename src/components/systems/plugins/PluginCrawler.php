<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\Plugin;
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
use jeyroik\extas\interfaces\systems\extensions\IExtensionRepository;
use jeyroik\extas\interfaces\systems\plugins\IPluginStage;
use jeyroik\extas\interfaces\systems\plugins\stages\IStageRepository;

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

    protected $plugins = ['Plugin class'];
    protected $pluginsLoaded = 0;
    protected $pluginsAlreadyLoaded = 0;

    protected $extensions = ['Interface : Extension class'];
    protected $extensionsLoaded = 0;
    protected $extensionsAlreadyLoaded = 0;

    protected $rewrite = 0;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var ICrawlerPackage[]
     */
    protected $packages = [];

    /**
     * @var array
     */
    protected $warnings = [];

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
     * @param $rewrite
     *
     * @return int
     * @throws \Exception
     */
    public function crawlPlugins($rewrite = 0): int
    {
        if (empty($this->rootPath)) {
            throw new \Exception('Missed root path for Extas plugins crawling.');
        }

        $this->rewrite = $rewrite;
        $this->loadPackages();

        return count($this->packages);
    }

    /**
     * @return array
     */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /**
     * @return int
     */
    public function getPluginsLoaded(): int
    {
        return $this->pluginsLoaded;
    }

    /**
     * @return int
     */
    public function getPluginsAlreadyLoaded(): int
    {
        return $this->pluginsAlreadyLoaded;
    }

    /**
     * @return array
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @return int
     */
    public function getExtensionsLoaded(): int
    {
        return $this->extensionsLoaded;
    }

    /**
     * @return int
     */
    public function getExtensionsAlreadyLoaded(): int
    {
        return $this->extensionsAlreadyLoaded;
    }

    /**
     * @return ICrawlerPackage[]
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @return bool
     */
    public function hasWarnings(): bool
    {
        return !empty($this->warnings);
    }

    /**
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
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
        $this->rootPackagePath = $this->rootPath . '/' . $rootPackageName;

        if (!is_callable($rootPackageExtractor)) {
            $rootPackageExtractor = new $rootPackageExtractor();
        }

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

        if ($package && ($package->getVersion() == $packageRoot->getVersion())) {
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

    /**
     * @param $packages
     *
     * @return $this
     * @throws \Exception
     */
    protected function grabPackages($packages)
    {
        /**
         * @var $storage IRepository
         */
        $storage = SystemContainer::getItem(IPackageRepository::class);
        $packageExtractor = $this->getPackageExtractor();

        foreach ($packages as $packageName => $packageInfo) {
            /**
             * @var $packageDb ICrawlerPackage
             * @var $package ICrawlerPackage
             */
            $packageDb = $storage->find([ICrawlerPackage::FIELD__NAME => $packageName])->one();
            $package = $packageExtractor(
                $this->rootPath,
                $packageInfo,
                $this->config[static::CONFIG__PACKAGE__CONFIG_NAME]
            );

            if ($this->rewriteIsOn()) {
                if ($package && $packageDb) {
                    $package->id = $packageDb->getId();
                }
                $storageMethod = $packageDb ? 'update' : 'create';
            } else {
                if ($packageDb) {
                    $package = $packageDb;
                    $storageMethod = 'update';
                } else {
                    $storageMethod = 'create';
                }
            }

            if ($package) {
                $this->packages[] = $package;
                $this->savePlugins($package->getPlugins())
                    ->saveExtensions($package->getExtensions());
                $storage->$storageMethod($package);
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
     * @throws \Exception
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
             * @var $extensionDb IExtension
             */
            $extensionDb = $storage->find([IExtension::FIELD__INTERFACE => $extension[IExtension::FIELD__INTERFACE]])
                ->one();

            if ($this->rewriteIsOn()) {
                $extension[IExtension::FIELD__ID] = $extensionDb ? $extensionDb->getId() : $extensionId;
                list($extensionDb, $storageMethod) = $extensionDb
                    ? [$extensionDb, 'update']
                    : [new Extension(), 'create'];
            } else {
                if ($extensionDb) {
                    $this->extensionsAlreadyLoaded++;
                    continue;
                }

                $this->checkMethodsForDuplicating(
                    $extension[IExtension::FIELD__SUBJECT],
                    $extension[IExtension::FIELD__METHODS],
                    $storage
                );

                $extensionDb = new Extension();
                $extension[IExtension::FIELD__ID] = $extensionId;
                $storageMethod = 'create';
            }
            $extensionDb = $this->fillInExtensionObject($extensionDb, $extension);
            $this->extensions[] = $extensionDb->getInterface() . ' : ' . $extensionDb->getClass();
            $this->extensionsLoaded++;
            $storage->$storageMethod($extensionDb);
        }

        $storage->commit();

        return $this;
    }

    /**
     * @param IExtension $extensionObject
     * @param array $extensionData
     *
     * @return IExtension
     */
    protected function fillInExtensionObject($extensionObject, $extensionData)
    {
        $extensionObject->setId($extensionData[IExtension::FIELD__ID])
            ->setSubject($extensionData[IExtension::FIELD__SUBJECT])
            ->setClass($extensionData[IExtension::FIELD__CLASS])
            ->setInterface($extensionData[IExtension::FIELD__INTERFACE])
            ->setMethods($extensionData[IExtension::FIELD__METHODS]);

        return $extensionObject;
    }

    /**
     * @param string $subject
     * @param array $methods
     * @param IExtensionRepository $storage
     *
     * @return $this
     * @throws \Exception
     */
    protected function checkMethodsForDuplicating($subject, $methods, $storage)
    {
        foreach ($methods as $method) {
            /**
             * @var $extensionWithTheSameMethod IExtension
             */
            $extensionWithTheSameMethod = $storage->find([
                IExtension::FIELD__SUBJECT => $subject,
                IExtension::FIELD__METHODS => $method
            ])->one();

            if ($extensionWithTheSameMethod) {
                throw new \Exception(
                    'Method "' . $method . '" is already reserved for the subject "'
                    . $subject . '" with the extension #'
                    . $extensionWithTheSameMethod->getId() . ' '
                    . $extensionWithTheSameMethod->getClass()
                );
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function rewriteIsOff(): bool
    {
        return !$this->rewriteIsOn();
    }

    /**
     * @return bool
     */
    protected function rewriteIsOn(): bool
    {
        return $this->rewrite == static::REWRITE__ON;
    }

    /**
     * @param $plugins
     *
     * @return $this
     * @throws \Exception
     */
    protected function savePlugins($plugins)
    {
        /**
         * @var $storage IPluginRepository
         */
        $storage = SystemContainer::getItem(IPluginRepository::class);

        /**
         * @var $stagesRepo IStageRepository
         */
        $stagesRepo = SystemContainer::getItem(IStageRepository::class);

        foreach ($plugins as $plugin) {
            $pluginId = $this->preparePluginId($plugin);

            /**
             * @var $pluginDb IPlugin
             */
            $pluginDb = $storage->find([IPlugin::FIELD__ID => $pluginId])->one();

            if ($this->rewriteIsOn()) {
                list($pluginId, $storageMethod) = $pluginDb
                    ? [$pluginDb->getId(), 'update']
                    : [$pluginId, 'create'];

            } else {
                if ($pluginDb) {
                    $this->pluginsAlreadyLoaded++;
                    continue;
                }
                $storageMethod = 'create';
            }

            $pluginDb = new Plugin();
            $pluginDb->setId($pluginId)
                ->setClass($plugin[IPlugin::FIELD__CLASS])
                ->setStage($plugin[IPlugin::FIELD__STAGE]);

            /**
             * @var $stage IPluginStage
             */
            $stage = $stagesRepo->find([IPluginStage::FIELD__NAME => $pluginDb->getStage()])->one();

            if (!$stage) {
                throw new \Exception(
                    'Unknown stage "' . $pluginDb->getStage() . '" for plugin "' . $pluginDb->getClass() . '".'
                );
            }

            $this->plugins[] = $pluginDb->getClass();
            $this->pluginsLoaded++;
            $storage->$storageMethod($pluginDb);
        }

        $storage->commit();

        return $this;
    }

    /**
     * @param $message
     *
     * @return $this
     */
    protected function addWarning($message)
    {
        $this->warnings[] = $message;

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
     * @param array $extension
     *
     * @return string
     */
    protected function prepareExtensionId($extension)
    {
        return sha1(json_encode($extension));
    }

    /**
     * @param $package ICrawlerPackage
     *
     * @return string
     */
    protected function preparePackageId($package)
    {
        return sha1(json_encode($package->__toArray()));
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
