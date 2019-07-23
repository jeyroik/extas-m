<?php
namespace extas\components\plugins\states;

use extas\components\plugins\Plugin;

/**
 * Class StatePluginDemoEnd
 *
 * @package extas\components\plugins\states
 * @author jeyroik@gmail.com
 */
class StatePluginDemoEnd extends Plugin
{
    /**
     * @param $state
     * @param $context
     * @param $machine
     * @param $isSuccess
     */
    public function __invoke($state, $context, $machine, &$isSuccess)
    {
        $isSuccess = true;
        echo 'Finished demo machine with the context: <pre>' . print_r($context, true) . '</pre>';
    }
}
