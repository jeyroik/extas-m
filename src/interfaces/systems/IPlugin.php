<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPlugin
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPlugin extends IItem
{
    const FIELD__CLASS = 'class';
    const FIELD__STAGE = 'stage';
    const FIELD__ID = 'id';

    const SUBJECT = 'plugin';

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getStage(): string;

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id);

    /**
     * @param $class
     *
     * @return $this
     */
    public function setClass($class);

    /**
     * @param $stage
     *
     * @return $this
     */
    public function setStage($stage);
}
