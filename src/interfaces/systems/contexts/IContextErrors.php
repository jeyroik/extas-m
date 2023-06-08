<?php
namespace jeyroik\extas\interfaces\systems\contexts;

use jeyroik\extas\interfaces\systems\IContext;

/**
 * Interface IContextErrors
 *
 * todo mv to extensions directory
 *
 * @package jeyroik\extas\interfaces\systems\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextErrors
{
    /**
     * @param mixed $error
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function addError($error, IContext &$context = null);

    /**
     * @return mixed
     */
    public function getErrors();
}