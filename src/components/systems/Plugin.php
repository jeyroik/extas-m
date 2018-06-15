<?php
namespace tratabor\components\systems;

use tratabor\interfaces\systems\IPlugin;

/**
 * Class Plugin
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Plugin implements IPlugin
{
    /**
     * @var string
     */
    protected $version = '';

    /**
     * @var string
     */
    protected $class = '';

    /**
     * @var string
     */
    protected $stage = '';

    /**
     * Plugin constructor.
     * @param $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config);
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
     * @param $config
     *
     * @return $this
     */
    protected function setConfig($config)
    {
        $this->version = $config['version'] ?? '';
        $this->class = $config['class'] ?? '';
        $this->stage = $config['stage'] ?? '';

        return $this;
    }
}
