<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use jeyroik\extas\interfaces\systems\IExtension;

/**
 * Trait TExtendable
 *
 * @package jeyroik\extas\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
trait TExtendable
{
    /**
     * @var array
     */
    protected $registeredInterfaces = [];

    /**
     * @var array
     */
    protected $extendedMethodToInterface = [];

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        if (isset($this->extendedMethodToInterface[$name])) {

            /**
             * @var $interfaceRealization IExtension
             */
            $interfaceRealization = $this->registeredInterfaces[$this->extendedMethodToInterface[$name]];

            /**
             * @var $pluginRepo IPluginRepository
             */
            $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

            foreach ($pluginRepo::getPluginsForStage(
                static::class,
                IExtendable::STAGE__EXTENDED_METHOD_CALL
            ) as $plugin) {
                $arguments = $plugin($this, $name, $arguments);
            }

            return $interfaceRealization->runMethod($this, $name, $arguments);
        }

        throw new \Exception('Call unknown or unregistered method "' . $name . '".');
    }

    /**
     * @param string $interface
     * @param IExtension $interfaceImplementation
     *
     * @return bool
     */
    public function registerInterface(string $interface, IExtension $interfaceImplementation): bool
    {
        if (!$this->isImplementsInterface($interface)) {
            $this->registeredInterfaces[$interface] = $interfaceImplementation;
            $methods = $interfaceImplementation->getMethodsNames();
            $this->extendedMethodToInterface += $methods;

            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function isImplementsInterface(string $interface): bool
    {
        return isset($this->registeredInterfaces[$interface]);
    }
}
