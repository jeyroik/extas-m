<?php
namespace extas\components\plugins\states;

use extas\components\plugins\Plugin;
use extas\interfaces\contexts\IContext;
use extas\interfaces\machines\IMachine;
use extas\interfaces\machines\states\IMachineState;

/**
 * Class StatePluginValidationParameters
 *
 * @package extas\components\plugins\states
 * @author jeyroik@gmail.com
 */
class StatePluginValidationParameters extends Plugin
{
    /**
     * @param IMachineState $state
     * @param IContext $context
     * @param bool $isValid
     * @param IMachine $machine
     */
    public function __invoke($state, $context, &$isValid, $machine)
    {
        $stateParameters = $state->getParameters();
        foreach ($stateParameters as $parameter) {
            if (!isset($context[$parameter->getName()])) {
                $isValid = false;
                $context['Error [' . __METHOD__ . ']'] =
                    'Context missed required state parameter "' . $parameter->getName() . '"';
                break;
            }
        }
    }
}
