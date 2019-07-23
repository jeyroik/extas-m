<?php
namespace extas\components\contexts;

use extas\components\Item;
use extas\interfaces\contexts\IContext;

/**
 * Class Context
 *
 * @package jeyroik\extas\components\systems
 * @author jeyroik@gmail.com
 */
class Context extends Item implements IContext
{
    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
