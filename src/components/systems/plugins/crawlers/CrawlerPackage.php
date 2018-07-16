<?php
namespace jeyroik\extas\components\systems\plugins\crawlers;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;

/**
 * Class CrawlerPluginInfo
 *
 * @package jeyroik\extas\components\systems\plugins\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
class CrawlerPackage extends Item implements ICrawlerPackage
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

    const CONFIG__PACKAGE = 'package';

    protected $config = [];

    /**
     * @return array|mixed
     */
    public function getPackage()
    {
        return $this->config[static::CONFIG__PACKAGE] ?? [];
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
