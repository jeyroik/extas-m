<?php
namespace jeyroik\extas\interfaces\systems\states\dispatchers;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IDispatchersFactory
 *
 * @package jeyroik\extas\interfaces\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
interface IDispatchersFactory extends IItem
{
    const SUBJECT = 'state.dispatcher.factory';

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
