<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IExtension
 *
 * @stage.expand.type IExtension
 * @stage.expand.name jeyroik\extas\interfaces\systems\IExtension
 *
 * @stage.name extension.init
 * @stage.description Extension initialization finish
 * @stage.input IExtension
 * @stage.output void
 *
 * @stage.name extension.after
 * @stage.description Extension destructing
 * @stage.input IExtension
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IExtension extends IItem
{
    const SUBJECT = 'extension';

    const STAGE__EXTENSION_INIT = 'extension.init';
    const STAGE__EXTENSION_AFTER = 'extension.after';

    const FIELD__CLASS = 'class';
    const FIELD__INTERFACE = 'interface';
    const FIELD__SUBJECT = 'subject';
    const FIELD__METHODS = 'methods';
    const FIELD__ID = 'id';

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

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getInterface(): string;

    /**
     * @return string
     */
    public function getSubject(): string;

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * @param $interface
     *
     * @return $this
     */
    public function setInterface($interface);

    /**
     * @param $methods
     *
     * @return $this
     */
    public function setMethods($methods);

    /**
     * @param $subject
     *
     * @return $this
     */
    public function setSubject($subject);

    /**
     * @param $class
     *
     * @return $this
     */
    public function setClass($class);
}
