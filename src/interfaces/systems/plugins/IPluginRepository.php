<?php
namespace jeyroik\extas\interfaces\systems\plugins;

use jeyroik\extas\interfaces\systems\IRepository;

/**
 * Interface IPluginRepository
 *
 * @package jeyroik\extas\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginRepository extends IRepository
{
    /**
     * @param $stage
     *
     * @return bool
     */
    public function hasStagePlugins($stage): bool;

    /**
     * @param $stage
     *
     * @return \Generator
     */
    public function getStagePlugins($stage);
}
