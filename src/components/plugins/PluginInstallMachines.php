<?php
namespace extas\components\plugins;

use extas\components\machines\Machine;
use extas\interfaces\machines\IMachineRepository;

/**
 * Class PluginInstallMachines
 *
 * @package extas\components\plugins
 * @author jeyroik@gmail.com
 */
class PluginInstallMachines extends PluginInstallDefault
{
    protected string $selfItemClass = Machine::class;
    protected string $selfRepositoryClass = IMachineRepository::class;
    protected string $selfUID = Machine::FIELD__NAME;
    protected string $selfSection = 'machines';
    protected string $selfName = 'machine';
}
