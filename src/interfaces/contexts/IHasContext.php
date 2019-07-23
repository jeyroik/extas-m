<?php
namespace extas\interfaces\contexts;

/**
 * Interface IHasContext
 *
 * @package extas\interfaces\contexts
 * @author jeyroik@gmail.com
 */
interface IHasContext
{
    const FIELD__CONTEXT = 'context';

    /**
     * @return IContext
     */
    public function getContext(): IContext;

    /**
     * @param array|IContext $context
     *
     * @return $this
     */
    public function setContext($context);
}
