<?php
namespace jeyroik\extas\interfaces\systems\plugins\crawlers;

/**
 * Interface ICrawlerPluginInfo
 *
 * @package jeyroik\extas\interfaces\systems\plugins\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
interface ICrawlerPluginInfo
{
    public function getName(): string;
    public function getDescription(): string;

    public function getRequire();
    public function getRequireExtensions();
    public function getRequirePlugins();

    /**
     * @return array
     */
    public function getRequireInterfaces();


    /**
     * @return array
     */
    public function getProduce();


    public function getProduceExtensions();


    public function getProducePlugins();


    public function getProduceInterfaces();

    /**
     * @return string
     */
    public function getInfoHash(): string;
}
