<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\components\systems\plugins\TPluginAcceptable;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use jeyroik\extas\interfaces\systems\IExtension;
use tratabor\interfaces\systems\extensions\IExtensionRepository;

/**
 * Trait TExtendable
 *
 * @package jeyroik\extas\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
trait TExtendable
{
    use TPluginAcceptable;

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
        /**
         * @var $extRepo IExtensionRepository
         */
        $extRepo = SystemContainer::getItem(IExtensionRepository::class);
        $extension = $extRepo::getExtension($this->getSubjectForExtension(), $name);

        if (is_string($extension)) {
            throw new \Exception($extension);
        }

        foreach ($this->getPluginsByStage(IExtendable::STAGE__EXTENDED_METHOD_CALL) as $plugin) {
            $arguments = $plugin($this, $name, $arguments);
        }

        return $extension->runMethod($this, $name, $arguments);
    }

    /**
     * @param string $interface
     * @param IExtension $interfaceImplementation
     *
     * @return bool
     */
    public function registerInterface(string $interface, IExtension $interfaceImplementation): bool
    {
        /**
         * @var $extRepo IExtensionRepository
         */
        $extRepo = SystemContainer::getItem(IExtensionRepository::class);

        return $extRepo::addExtension(
            $this,
            $interface,
            $interfaceImplementation,
            $interfaceImplementation->getMethodsNames()
        );
    }

    /**
     * @param string $interface
     *
     * @return bool
     */
    public function isImplementsInterface(string $interface): bool
    {
        /**
         * @var $extRepo IExtensionRepository
         */
        $extRepo = SystemContainer::getItem(IExtensionRepository::class);

        return $extRepo::hasInterfaceImplementation($interface);
    }

    /**
     * @return string
     */
    abstract protected function getSubjectForExtension(): string;
}
