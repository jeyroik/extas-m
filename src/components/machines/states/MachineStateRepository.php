<?php
namespace extas\components\states;

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
    protected $pk = MachineState::FIELD__NAME;
    protected $name = 'state';
    protected $scope = 'extas';
    protected $itemClass = MachineState::class;
    protected $idAs = '';
}
