<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\components\systems\plugins\TPluginAcceptable;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IExtendable;
use jeyroik\extas\interfaces\systems\IExtension;
use jeyroik\extas\interfaces\systems\extensions\IExtensionRepository;

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

        /**
         * @var $extension IExtension
         */
        $extension = $extRepo->find([
            IExtension::FIELD__SUBJECT => $this->getSubjectForExtension(),
            IExtension::FIELD__METHODS => $name
        ])->one();

        if (!$extension) {
            throw new \Exception('Unknown method "' . get_class($this) . ':' . $name . '".');
        }

        foreach ($this->getPluginsByStage(IExtendable::STAGE__EXTENDED_METHOD_CALL) as $plugin) {
            $arguments = $plugin($this, $name, $arguments);
        }

        return $extension->runMethod($this, $name, $arguments);
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

        return $extRepo->find([IExtension::FIELD__INTERFACE => $interface])->one() ? true : false;
    }

    /**
     * @return string
     */
    abstract protected function getSubjectForExtension(): string;
}
