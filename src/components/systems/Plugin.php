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
    protected $preDefinedVersion = '';
    protected $preDefinedClass = '';
    protected $preDefinedStage = '';

    /**
     * @param $config
     *
     * @return IPlugin
     */
    protected function setConfig($config)
    {
        $this->preDefinedClass && $config[static::FIELD__CLASS] = $this->preDefinedClass;
        $this->preDefinedVersion && $config[static::FIELD__VERSION] = $this->preDefinedVersion;
        $this->preDefinedStage && $config[static::FIELD__STAGE] = $this->preDefinedStage;

        return parent::setConfig($config);
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
