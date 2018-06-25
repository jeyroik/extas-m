<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\interfaces\systems\IExtension;
use tratabor\interfaces\systems\extensions\IExtensionRepository;

/**
 * Class ExtensionRepository
 *
 * @package jeyroik\extas\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionRepository implements IExtensionRepository
{
    const CONFIG__METHODS = 0;
    const CONFIG__IMPLEMENTATIONS = 1;

    const CONFIG__CLASS = 0;
    const CONFIG__ARGUMENTS = 1;

    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @param $interface
     *
     * @return bool
     */
    public static function hasInterfaceImplementation($interface): bool
    {
        return static::getInstance()->hasImplementation($interface);
    }

    /**
     * @param $subject
     * @param $interface
     * @param $interfaceImplementation
     * @param array $methods
     *
     * @return bool
     */
    public static function addExtension($subject, $interface, $interfaceImplementation, $methods = []): bool
    {
        try {
            static::getInstance()->addExtensionFor($subject, $interface, $interfaceImplementation, $methods);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $subject
     * @param $method
     *
     * @return IExtension|string
     */
    public static function getExtension($subject, $method)
    {
        try {
            $extension = self::getInstance()->getInterfaceImplementationFor($subject, $method);
            return $extension;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return static::$instance ?: static::$instance = new static();
    }

    /**
     * ExtensionRepository constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->loadFromConfig($config);
    }

    /**
     * @param string|object $subject
     * @param string $method
     *
     * @return mixed
     * @throws \Exception
     */
    public function getInterfaceImplementationFor($subject, $method)
    {
        $subject = is_object($subject) ? get_class($subject) : $subject;

        if (!isset($this->config[static::CONFIG__METHODS][$subject])) {
            throw new \Exception('Unknown subject "' . $subject . '".');
        }

        if (!isset($this->config[static::CONFIG__METHODS][$subject][$method])) {
            throw new \Exception('Unknown method "' . $method . '" for subject "' . $subject . '".');
        }

        $interface = $this->config[static::CONFIG__METHODS][$subject][$method];

        if (!$this->hasImplementation($interface)) {
            throw new \Exception('Missed implementation of "' . $interface . '".');
        }

        $implementation = $this->config[static::CONFIG__IMPLEMENTATIONS][$interface];

        if (is_string($implementation)) {
            $this->config[static::CONFIG__IMPLEMENTATIONS][$interface] = new $implementation;
        } elseif (is_array($implementation)) {
            $implementationClass = $implementation[static::CONFIG__CLASS];
            $implementationArgs = $implementation[static::CONFIG__ARGUMENTS];

            $this->config[static::CONFIG__IMPLEMENTATIONS][$interface] = new $implementationClass($implementationArgs);
        }

        return $this->config[static::CONFIG__IMPLEMENTATIONS][$interface];
    }

    /**
     * @param $subject
     * @param $interface
     * @param $interfaceImplementation
     * @param array $methods
     *
     * @return bool
     * @throws \Exception
     */
    public function addExtensionFor($subject, $interface, $interfaceImplementation, $methods = [])
    {
        $subject = is_object($subject) ? get_class($subject) : $subject;

        if (!isset($this->config[static::CONFIG__METHODS][$subject])) {
            $this->config[static::CONFIG__METHODS][$subject] = [];
        }

        if (isset($this->config[static::CONFIG__IMPLEMENTATIONS][$interface])) {
            throw new \Exception('Interface "' . $interface . '" already has implementation.');
        }

        $this->config[static::CONFIG__IMPLEMENTATIONS][$interface] = $interfaceImplementation;

        foreach ($methods as $method) {
            if (isset($this->config[static::CONFIG__METHODS][$subject][$method])) {
                throw new \Exception('Method "' . $method . '" already has implementation.');
            }
            $this->config[static::CONFIG__METHODS][$subject][$method] = $interface;
        }

        return true;
    }

    /**
     * @param $interface
     *
     * @return bool
     */
    public function hasImplementation($interface)
    {
        return isset($this->config[static::CONFIG__IMPLEMENTATIONS][$interface]);
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function loadFromConfig($config = [])
    {
        if (empty($config)) {
            $cfgPath = getenv('G5__EXTENSION_REPOSITORY__PATH')
                ?: G5__ROOT_PATH . '/resources/configs/extensions.php';

            if (is_file($cfgPath)) {
                $config = include $cfgPath;
            }
        }

        $this->config = $config;

        return $this;
    }
}
