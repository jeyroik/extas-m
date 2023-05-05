<?php
namespace jeyroik\extas\interfaces\systems\states\dispatchers;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IDispatchersFactory
 *
 * @stage.expand.type IFactory
 * @stage.expand.name jeyroik\extas\interfaces\systems\states\dispatchers\IDispatcherFactory
 *
 * @stage.name state.dispatcher.factory.cinit
 * @stage.description State dispatcher factory initialization finish
 * @stage.input IFactory $factory
 * @stage.output void
 *
 * @stage.name state.dispatcher.factory.after
 * @stage.description State dispatcher factory destructing
 * @stage.input IFactory $factory
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
interface IDispatchersFactory extends IItem
{
    const SUBJECT = 'state.dispatcher.factory';

    const STAGE__STATE_DISPATCHER_FACTORY_INIT = 'state.dispatcher.factory.init';
    const STAGE__STATE_DISPATCHER_FACTORY_AFTER = 'state.dispatcher.factory.after';

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
