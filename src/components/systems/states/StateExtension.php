<?php
namespace tratabor\components\systems\states;

use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateExtension;

/**
 * Class StatePlugin
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
abstract class StateExtension implements IStateExtension
{
    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @var IState
     */
    protected $state = null;

    /**
     * @param object $extendingSubject
     * @param string $methodName
     * @param $args
     *
     * @return mixed|null
     */
    public function runMethod(&$extendingSubject, $methodName, $args)
    {
        if (method_exists($this, $methodName)) {
            $this->state = $extendingSubject;
            return call_user_func_array([$this, $methodName], $args);
        }

        return null;
    }

    /**
     * @return array
     */
    public function getMethodsNames()
    {
        return $this->methods;
    }
}
