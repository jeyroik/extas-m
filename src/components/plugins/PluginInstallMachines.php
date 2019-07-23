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
    protected $selfItemClass = Machine::class;
    protected $selfRepositoryClass = IMachineRepository::class;
    protected $selfUID = Machine::FIELD__NAME;
    protected $selfSection = 'machines';
    protected $selfName = 'machine';
}
