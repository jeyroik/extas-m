<?php
namespace extas\components\plugins\states;

use extas\components\plugins\Plugin;

/**
 * Class StatePluginDemoInit
 *
 * @package extas\components\plugins\states
 * @author jeyroik@gmail.com
 */
class StatePluginDemoInit extends Plugin
{
    /**
     * @param $state
     * @param $context
     * @param $machine
     * @param $isSuccess
     */
    public function __invoke($state, &$context, $machine, &$isSuccess)
    {
        $isSuccess = true;
        $context['initialized'] = true;
        echo 'Initialized demo machine with the context: <pre>' . print_r($context, true) . '</pre>';
        echo 'Set to context initialized = true';
    }
}
