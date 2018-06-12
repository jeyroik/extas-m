<?php
namespace tratabor\interfaces\systems\states\dispatchers;

/**
 * Interface IDispatchersFactory
 *
 * @package tratabor\interfaces\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
interface IDispatchersFactory
{
    /**
     * @param $dispatcherConfig
     * @param string $dispatcherId
     *
     * @return mixed
     */
    public static function buildDispatcher($dispatcherConfig, $dispatcherId = null);

    /**
     * This is syntax shugar.
     * Return false if dispatcher registration is failed.
     *
     * @param $dispatcherConfig
     * @param string $dispatcherId
     *
     * @return bool
     */
    public static function registerDispatcher($dispatcherConfig, $dispatcherId): bool;
}
