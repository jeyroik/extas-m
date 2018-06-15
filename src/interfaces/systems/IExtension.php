<?php
namespace tratabor\interfaces\systems;

/**
 * Interface IExtension
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtension
{
    /**
     * @return string[]
     */
    public function getMethodsNames();

    /**
     * @param object $extendingSubject
     * @param string $methodName
     * @param $args
     *
     * @return mixed
     */
    public function runMethod(&$extendingSubject, $methodName, $args);
}
