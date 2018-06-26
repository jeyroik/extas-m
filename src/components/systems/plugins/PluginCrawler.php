<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPluginInfo;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPluginInfo;
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
     * @var ICrawlerPluginInfo[]
     */
    protected $plugins = [];

    /**
     * PluginCrawler constructor.
     *
     * @param string $rootPath
     */
    public function __construct($rootPath = '')
    {
        $this->setRootPath($rootPath);
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function crawlPlugins(): int
    {
        if (empty($this->rootPath)) {
            throw new \Exception('Missed root path for Extas plguins crawling.');
        }

        $finder = new Finder();
        $finder->name('extas.json');

        foreach ($finder->in($this->rootPath . '/*/')->files() as $file) {
            /**
             * @var $file SplFileInfo
             */
            $json = $file->getContents();

            try {
                $jsonDecoded = json_decode($json);
                $pluginInfo = new CrawlerPluginInfo($jsonDecoded);
                $this->plugins[$pluginInfo->getName()] = $pluginInfo;
            } catch (\Exception $e) {
                continue;
            }
        }

        return count($this->plugins);
    }

    /**
     * @param $extasPluginConfigPath
     *
     * @return CrawlerPluginInfo
     * @throws \Exception
     */
    public function registerPlugin($extasPluginConfigPath)
    {
        if (is_file($extasPluginConfigPath)) {
            $infoConfig = json_decode(file_get_contents($extasPluginConfigPath), true);
            $info = new CrawlerPluginInfo($infoConfig);
            $this->plugins[$info->getName()] = $info;
        } else {
            throw new \Exception('Missed or restricted plugin config path "' . $extasPluginConfigPath . '".');
        }

        return $info;
    }

    /**
     * @param string $pluginName
     *
     * @return ICrawlerPluginInfo|null
     */
    public function getPluginInfo($pluginName)
    {
        return $this->plugins[$pluginName] ?? null;
    }

    /**
     * @return ICrawlerPluginInfo[]
     */
    public function getPluginsInfo()
    {
        return $this->plugins;
    }

    protected function setRootPath($rootPath)
    {
        $this->rootPath = $rootPath;

        return $this;
    }
}
