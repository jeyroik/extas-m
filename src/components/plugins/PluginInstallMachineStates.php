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
    protected string $selfName = 'machine state';
    protected string $selfSection = 'machine_states';
    protected string $selfUID = MachineState::FIELD__NAME;
    protected string $selfRepositoryClass = IMachineStateRepository::class;
    protected string $selfItemClass = MachineState::class;
}
