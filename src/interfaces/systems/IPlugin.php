<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPlugin
 *
 * @stage.expand.type IPlugin
 * @stage.expand.name jeyroik\extas\interfaces\systems\IPlugin
 *
 * @stage.name plugin.init
 * @stage.description Plugin initialization finish
 * @stage.input IPlugin
 * @stage.output void
 *
 * @stage.name plugin.after
 * @stage.description Plugin destructing
 * @stage.input IPlugin
 * @stage.output void
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPlugin extends IItem
{
    const SUBJECT = 'plugin';

    const STAGE__PLUGIN_INIT = 'plugin.init';
    const STAGE__PLUGIN_AFTER = 'plugin.after';

    const FIELD__CLASS = 'class';
    const FIELD__STAGE = 'stage';
    const FIELD__ID = 'id';

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
