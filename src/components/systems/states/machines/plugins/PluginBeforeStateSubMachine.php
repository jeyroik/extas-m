<?php
namespace tratabor\components\systems\states\machines\plugins;

use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\plugins\IPluginBeforeStateRun;

/**
 * Class PluginBeforeStateRunSubMachine
 *
 * @package tratabor\components\systems\states\machines\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginBeforeStateRunSubMachine implements IPluginBeforeStateRun
{
    /**
     * @param IStateMachine $machine
     * @param string $stateId
     *
     * @return string
     */
    public function __invoke(IStateMachine $machine, $stateId = '')
    {
        /**
         * State is a StateMachine
         */
        if (is_array($stateId)) {
            /**
             * @var $subMachine IStateMachine
             */
            $subMachine = new $machine($stateId, $machine->getCurrentContext());
            return $subMachine->run($stateId);
        }

        return $stateId;
    }
}
