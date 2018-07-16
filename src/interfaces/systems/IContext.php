<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IContext
 *
 * @stage.expand.type IContext
 * @stage.expand.name jeyroik\extas\interfaces\systems\IContext
 *
 * @stage.name context.init
 * @stage.description Context initialization finish
 * @stage.input IContext
 * @stage.output void
 *
 * @stage.name context.after
 * @stage.description Context destructing
 * @stage.input IContext
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IContext extends IItem
{
    const SUBJECT = 'context';

    const STAGE__CONTEXT_INIT = 'context.init';
    const STAGE__CONTEXT_AFTER = 'context.after';

    /**
     * @param string $name
     *
     * @return IContext
     */
    public function setReadOnly($name);
}
