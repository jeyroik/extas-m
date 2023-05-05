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
    public function getId(): string
    {
        return $this->config[static::FIELD__ID] ?? '';
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
     * @param string $name
     *
     * @return mixed
     */
    public function getExtensions($name = '')
    {
        return $this->config[static::FIELD__EXTENSIONS] ?? [];
    }

    /**
     * @param $extensions
     *
     * @return $this
     */
    public function setExtensions($extensions)
    {
        $this->config[static::FIELD__EXTENSIONS] = $extensions;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getPlugins($name = '')
    {
        return $this->config[static::FIELD__PLUGINS] ?? [];
    }

    /**
     * @param $plugins
     *
     * @return $this
     */
    public function setPlugins($plugins)
    {
        $this->config[static::FIELD__PLUGINS] = $plugins;

        return $this;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->config[static::FIELD__DESCRIPTION] = $description;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->config[static::FIELD__NAME] = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->config[static::FIELD__TITLE] ?? '';
    }

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->config[static::FIELD__TITLE] = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->config[static::FIELD__VERSION] ?? '';
    }

    /**
     * @param $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->config[static::FIELD__VERSION] = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->config[static::FIELD__STATE] ?? '';
    }

    /**
     * @param $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->config[static::FIELD__STATE] = $state;

        return $this;
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
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return 'crawler.package';
    }
}
