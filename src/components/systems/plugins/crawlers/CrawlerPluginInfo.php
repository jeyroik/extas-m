<?php
namespace jeyroik\extas\components\systems\plugins\crawlers;

use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPluginInfo;

/**
 * Class CrawlerPluginInfo
 *
 * @package jeyroik\extas\components\systems\plugins\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerPluginInfo implements ICrawlerPluginInfo
{
    const CONFIG__NAME = 'name';
    const CONFIG__DESCRIPTION = 'description';

    const CONFIG__REQUIRE = 'require';
    const CONFIG__REQUIRE_EXTENSIONS = 'extensions';
    const CONFIG__REQUIRE_PLUGINS = 'plugins';
    const CONFIG__REQUIRE_INTERFACES = 'interfaces';

    const CONFIG__PRODUCE = 'produce';
    const CONFIG__PRODUCE_EXTENSIONS = 'extensions';
    const CONFIG__PRODUCE_PLUGINS = 'plugins';
    const CONFIG__PRODUCE_INTERFACES = 'interfaces';

    protected $config = [];

    /**
     * CrawlerPluginInfo constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->config[static::CONFIG__NAME] ?? '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->config[static::CONFIG__DESCRIPTION] ?? '';
    }

    /**
     * @return array|mixed
     */
    public function getRequire()
    {
        return $this->config[static::CONFIG__REQUIRE] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getRequireExtensions()
    {
        $require = $this->getRequire();

        return $require[static::CONFIG__REQUIRE_EXTENSIONS] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getRequirePlugins()
    {
        $require = $this->getRequire();

        return $require[static::CONFIG__REQUIRE_PLUGINS] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getRequireInterfaces()
    {
        $require = $this->getRequire();

        return $require[static::CONFIG__REQUIRE_INTERFACES] ?? [];
    }

    /**
     * @return array
     */
    public function getProduce()
    {
        return $this->config[static::CONFIG__PRODUCE] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getProduceExtensions()
    {
        $produce = $this->getProduce();

        return $produce[static::CONFIG__PRODUCE_EXTENSIONS] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getProducePlugins()
    {
        $produce = $this->getProduce();

        return $produce[static::CONFIG__PRODUCE_PLUGINS] ?? [];
    }

    /**
     * @return array
     */
    public function getProduceInterfaces()
    {
        $produce = $this->getProduce();

        return $produce[static::CONFIG__REQUIRE_INTERFACES] ?? [];
    }

    /**
     * @return string
     */
    public function getInfoHash(): string
    {
        return sha1(json_encode($this->config));
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
}
