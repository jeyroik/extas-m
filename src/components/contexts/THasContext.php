<?php
namespace extas\components\contexts;

use extas\interfaces\contexts\IContext;
use extas\interfaces\contexts\IHasContext;

/**
 * Trait THasContext
 *
 * @property $config
 *
 * @package extas\components\contexts
 * @author jeyroik@gmail.com
 */
trait THasContext
{
    /**
     * @return IContext
     */
    public function getContext(): IContext
    {
        $contextData = $this->config[IHasContext::FIELD__CONTEXT] ?? [];

        return new Context($contextData);
    }

    /**
     * @param array|IContext $context
     *
     * @return $this
     */
    public function setContext($context)
    {
        $this->config[IHasContext::FIELD__CONTEXT] = $context instanceof IContext
            ? $context->__toArray()
            : $context;

        return $this;
    }
}
