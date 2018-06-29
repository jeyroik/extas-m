<?php
namespace jeyroik\extas\components\systems\states\machines\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\states\StateMachine;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IPlugin;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\interfaces\systems\states\machines\plugins\IPluginInitContext;

/**
 * Class PluginInitContextSuccess
 *
 * @package jeyroik\extas\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginInitContextSuccess extends Plugin implements IPlugin
{
    const CONTEXT__SUCCESS = '@directive.success()';

    protected $preDefinedStage = IContext::SUBJECT . '.init';
    protected $preDefinedVersion = '1.0';

    /**
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IContext $context)
    {
        if (!isset($context[PluginInitContextSuccess::CONTEXT__SUCCESS])) {
            $context[PluginInitContextSuccess::CONTEXT__SUCCESS] = true;
        }

        return $context;
    }
}
