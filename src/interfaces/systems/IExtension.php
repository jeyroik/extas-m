<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IExtension
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtension extends IItem
{
    const SUBJECT = 'extension';

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
