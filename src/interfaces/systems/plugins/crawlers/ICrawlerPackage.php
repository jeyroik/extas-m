<?php
namespace jeyroik\extas\interfaces\systems\plugins\crawlers;

/**
 * Interface ICrawlerPackage
 *
 * @package jeyroik\extas\interfaces\systems\plugins\crawlers
 * @author Funcraft <me@funcraft.ru>
 */
interface ICrawlerPackage
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function getRequire($name = '');

    /**
     * @return mixed
     */
    public function getPackage();

    /**
     * @param $name
     *
     * @return array
     */
    public function getProduce($name = '');

    /**
     * @return string
     */
    public function getInfoHash(): string;
}
