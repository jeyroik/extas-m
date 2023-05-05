<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPluginsAcceptable
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginsAcceptable
{
    /**
     * @param string $stage
     *
     * @return IPlugin[]
     */
    public function getPluginsByStage($stage);
}
