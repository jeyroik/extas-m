<?php
namespace extas\components\plugins;

use extas\components\machines\states\MachineState;
use extas\interfaces\machines\states\IMachineStateRepository;

/**
 * Class PluginInstallMachineStates
 *
 * @package extas\components\plugins
 * @author jeyroik@gmail.com
 */
class PluginInstallMachineStates extends PluginInstallDefault
{
    protected $selfName = 'machine state';
    protected $selfSection = 'machine_states';
    protected $selfUID = MachineState::FIELD__NAME;
    protected $selfRepositoryClass = IMachineStateRepository::class;
    protected $selfItemClass = MachineState::class;
}
