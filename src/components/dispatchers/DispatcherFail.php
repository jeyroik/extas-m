<?php
namespace jeyroik\extas\components\dispatchers;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class DispatcherFail
 *
 * @package jeyroik\extas\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherFail extends DispatcherAbstract
{
    protected static $counter = 0;

    protected $requireInterfaces = [
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $context[static::class . '.' . static::$counter] = 'worked';
        $context->setFail();

        static::$counter++;

        return $context;
    }
}
