<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginInitContext;

/**
 * Class PluginInitContextErrors
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginInitContextErrors extends Plugin implements IPluginInitContext
{
    /**
     * @param IStateMachine $machine
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function __invoke(IStateMachine $machine, IContext $context = null)
    {
        $context->registerInterface(ExtensionContextErrors::class, new ExtensionContextErrors());

        return $context;
    }
}
