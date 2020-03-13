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
    protected string $idAs = '';
    protected string $itemClass = Machine::class;
    protected string $scope = 'extas';
    protected string $name = 'machines';
    protected string $pk = Machine::FIELD__NAME;
}
