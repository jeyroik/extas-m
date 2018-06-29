<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\interfaces\systems\IRepository;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;
use jeyroik\extas\interfaces\systems\plugins\IPluginCrawler;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var ICrawlerPackage[]
     */
    protected $plugins = [];

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

        list($packages, $packagesHash) = $this->grabComposer();

        $finder = new Finder();
        $finder->name('extas.json');

        $this->grabPlugins($finder, $packages, $packagesHash);

        return count($this->plugins);
    }

    /**
     * @param $extasPluginConfigPath
     *
     * @return CrawlerPackage
     * @throws \Exception
     */
    public function registerPlugin($extasPluginConfigPath)
    {
        if (is_file($extasPluginConfigPath)) {
            $infoConfig = json_decode(file_get_contents($extasPluginConfigPath), true);
            $info = new CrawlerPackage($infoConfig);
            $this->plugins[$info->getName()] = $info;
        } else {
            throw new \Exception('Missed or restricted plugin config path "' . $extasPluginConfigPath . '".');
        }

        return $info;
    }

    /**
     * @param string $pluginName
     *
     * @return ICrawlerPackage|null
     */
    public function getPluginInfo($pluginName)
    {
        return $this->plugins[$pluginName] ?? null;
    }

    /**
     * @return ICrawlerPackage[]
     */
    public function getPluginsInfo()
    {
        return $this->plugins;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function grabComposer()
    {
        $finder = new Finder();
        $finder->name('composer.lock');
        $composer = [];
        $packages = [];
        $packagesHash = '';

        foreach ($finder->in($this->rootPath . '/*') as $file) {
            /**
             * @var $file SplFileInfo
             */
            $composer = json_decode($file->getContents(), true);
        }

        if (!empty($composer)) {
            $packages = array_column($composer['packages'], null, 'name');
            $packagesHash = $composer['content-hash'];
        }

        if ($storage = $this->getPluginStorage()) {
            /**
             * @var $plugin ICrawlerPackage
             */
            $plugin = $storage->find([CrawlerPackage::CONFIG__NAME => 'package.composer'])->one();
            if ($plugin) {
                if ($packagesHash == $plugin->getDescription()) {
                    throw new \Exception('Plugins is already crawled.');
                }
            }
            $plugin = new CrawlerPackage([
                CrawlerPackage::CONFIG__NAME => 'package.composer',
                CrawlerPackage::CONFIG__DESCRIPTION => $packagesHash
            ]);
            $storage->create($plugin);
            $storage->commit();
        }

        return [$packages, $packagesHash];
    }

    /**
     * @param Finder $finder
     * @param array $packages
     * @param string $packagesHash
     *
     * @return $this
     */
    protected function grabPlugins($finder, $packages, $packagesHash)
    {
        $storage = $this->getPluginStorage();

        /**
         * @var $file SplFileInfo
         */
        foreach ($finder->in($this->rootPath . '/*/')->files() as $file) {
            $json = $file->getContents();

            try {
                $jsonDecoded = json_decode($json, true);
                $pluginInfo = new CrawlerPackage($jsonDecoded);
                $jsonDecoded[CrawlerPackage::CONFIG__PACKAGE] = isset($packages[$pluginInfo->getName()])
                    ? [
                        'version' => $packages[$pluginInfo->getName()]['version'],
                        'hash' => $packagesHash,
                        'source' => $packages[$pluginInfo->getName()]['source']
                    ] : [
                        'version' => 'unknown',
                        'hash' => $packagesHash,
                        'source' => []
                    ];
                $pluginInfo = new CrawlerPackage($jsonDecoded);
                $storage && $storage->create($pluginInfo);

                $this->plugins[$pluginInfo->getName()] = $pluginInfo;
            } catch (\Exception $e) {
                continue;
            }
        }

        return $this;
    }

    /**
     * @return null|IRepository
     */
    protected function getPluginStorage()
    {
        $storageClass = $this->config[static::CONFIG__PLUGIN_STORAGE__CLASS] ?? '';

        if($storageClass) {
            return new $storageClass();
        }

        return null;
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
