<?php
namespace tratabor\components\systems;

use tratabor\interfaces\systems\IExtension;

/**
 * Class Extension
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Extension implements IExtension
{
    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @param $subject
     * @param string $methodName
     * @param $args
     *
     * @return mixed|null
     */
    public function runMethod(&$subject, $methodName, $args)
    {
        array_push($args, $subject);

        return isset($this->methods[$methodName])
            ? call_user_func_array([$this, $methodName], $args)
            : null;
    }

    /**
     * @return array
     */
    public function getMethodsNames()
    {
        return $this->methods;
    }
}
