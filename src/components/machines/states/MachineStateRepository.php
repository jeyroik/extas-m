<?php
namespace extas\components\machines\states;

use extas\components\machines\states\MachineState;
use extas\components\repositories\Repository;
use extas\interfaces\machines\states\IMachineStateRepository;

/**
 * Class StateRepository
 *
 * @package extas\components\states
 * @author jeyroik@gmail.com
 */
class MachineStateRepository extends Repository implements IMachineStateRepository
{
    protected string $pk = MachineState::FIELD__NAME;
    protected string $name = 'state';
    protected string $scope = 'extas';
    protected string $itemClass = MachineState::class;
    protected string $idAs = '';
}
