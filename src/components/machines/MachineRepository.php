<?php
namespace extas\components\machines;

use extas\components\repositories\Repository;
use extas\interfaces\repositories\IRepository;

/**
 * Class MachineRepository
 *
 * @package extas\components\machines
 * @author jeyroik@gmail.com
 */
class MachineRepository extends Repository implements IRepository
{
    protected $idAs = '';
    protected $itemClass = Machine::class;
    protected $scope = 'extas';
    protected $name = 'machines';
    protected $pk = Machine::FIELD__NAME;
}
