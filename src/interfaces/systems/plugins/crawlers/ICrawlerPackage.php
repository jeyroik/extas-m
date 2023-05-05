<?php
namespace jeyroik\extas\interfaces\systems\plugins\crawlers;

use jeyroik\extas\interfaces\systems\IPackage;

/**
 * Interface ICrawlerPackage
 *
 * @package jeyroik\extas\interfaces\systems\plugins\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
interface ICrawlerPackage extends IPackage
{
    const FIELD__TITLE = 'title';
    const FIELD__PLUGINS = 'plugins';
    const FIELD__EXTENSIONS = 'extensions';

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getPlugins($name = '');

    /**
     * @param $name
     *
     * @return array
     */
    public function getExtensions($name = '');

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param $plugins
     *
     * @return $this
     */
    public function setPlugins($plugins);

    /**
     * @param $extensions
     *
     * @return $this
     */
    public function setExtensions($extensions);

    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title);
}
