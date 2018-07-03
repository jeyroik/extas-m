<?php
namespace jeyroik\extas\components\systems;

use jeyroik\extas\interfaces\systems\IPlugin;

/**
 * Class Plugin
 *
 * @property string $class
 * @property string $version
 * @property string $stage
 *
 * @package jeyroik\extas\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Plugin extends Item implements IPlugin
{
    public $preDefinedClass = '';
    public $preDefinedStage = '';

    /**
     * @param $config
     *
     * @return IPlugin
     */
    protected function setConfig($config)
    {
        $this->preDefinedClass && $config[static::FIELD__CLASS] = $this->preDefinedClass;
        $this->preDefinedStage && $config[static::FIELD__STAGE] = $this->preDefinedStage;

        return parent::setConfig($config);
    }

    /**
     * @param $stage
     *
     * @return $this
     */
    public function setStage($stage)
    {
        $this->stage = $stage;

        return $this;
    }

    /**
     * @param $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getStage(): string
    {
        return $this->stage;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
