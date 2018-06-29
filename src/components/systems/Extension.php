<?php
namespace jeyroik\extas\components\systems;

use jeyroik\extas\interfaces\systems\IExtension;

/**
 * Class Extension
 *
 * @package jeyroik\extas\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Extension extends Item implements IExtension
{
    /**
     * @var array
     */
    protected $methods = [];

    protected $subject = '';

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

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
