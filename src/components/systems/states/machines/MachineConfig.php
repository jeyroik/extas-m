<?php
namespace tratabor\components\systems\states\machines;

use tratabor\components\systems\plugins\TPluginAcceptable;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IPluginsAcceptable;
use tratabor\interfaces\systems\plugins\IPluginRepository;
use tratabor\interfaces\systems\states\IExtension;
use tratabor\interfaces\systems\states\IStateMachine;
use tratabor\interfaces\systems\states\machines\IMachineConfig;

/**
 * Class MachineConfig
 *
 * @package tratabor\components\systems\states\machines
 * @author Funcraft <me@funcraft.ru>
 */
class MachineConfig implements IMachineConfig
{
    use TPluginAcceptable;

    protected $config = [];
    protected $currentKey = 0;

    /**
     * @var IExtension[]
     */
    protected $registeredInterfaces = [];

    /**
     * @var array
     */
    protected $extendedMethodToInterface = [];

    /**
     * MachineConfig constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->setConfig($config);
        $this->registerPlugins(
            $this->config[IStateMachine::MACHINE__CONFIG][IStateMachine::MACHINE__CONFIG__PLUGINS] ?? []
        );
        $this->triggerCreated();
    }

    /**
     * @return array|mixed
     */
    public function getMachinePluginsList()
    {
        return $this->config[IPluginsAcceptable::FIELD__PLUGINS] ?? [];
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @param $stateId
     *
     * @return bool
     */
    public function hasState($stateId): bool
    {
        $states = $this->getStatesConfig();

        return isset($states[$stateId]);
    }

    /**
     * @param $stateId
     * @param $stateConfig
     *
     * @return $this
     */
    public function setState($stateId, $stateConfig)
    {
        $states = $this->getStatesConfig();
        $states[$stateId] = $stateConfig;

        $this->config[static::FIELD__STATES] = $states;

        return $this;
    }

    /**
     * @param $stateId
     *
     * @return array|mixed
     */
    public function getStateConfig($stateId)
    {
        $states = $this->getStatesConfig();

        return $states[$stateId] ?? [];
    }

    /**
     * @return array|mixed
     */
    public function getStatesConfig()
    {
        return $this->config[static::FIELD__STATES] ?? [];
    }

    /**
     * @return string
     */
    public function getEndState(): string
    {
        return $this->config[static::FIELD__END_STATE] ?? '';
    }

    /**
     * @return string
     */
    public function getStartState(): string
    {
        return $this->config[static::FIELD__START_STATE] ?? '';
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->config[static::FIELD__ALIAS] ?? '';
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->config[static::FIELD__VERSION];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->currentKey;
    }

    /**
     * @return mixed|null
     */
    public function current()
    {
        $keys = array_keys($this->config);
        $key = $keys[$this->currentKey] ?? '';

        return $this->config[$key] ?? null;
    }

    /**
     * @return void
     */
    public function next()
    {
        $keys = array_keys($this->config);
        if ($this->currentKey < (count($keys)-1)) {
            $this->currentKey++;
        } else {
            $this->currentKey = count($keys) - 1;
        }
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $keys = array_keys($this->config);

        return $this->currentKey < count($keys);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentKey = 0;
    }

    /**
     * @param mixed $offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->config[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->config[$offset]);
    }

    /**
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
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

    /**
     * @return void
     */
    public function __destruct()
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage($this, static::STAGE__DESTRUCTED) as $plugin) {
            $plugin($this);
        }
    }

    /**
     * @return $this
     */
    protected function triggerCreated()
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage($this, static::STAGE__CREATED) as $plugin) {
            $plugin($this);
        }

        return $this;
    }
}
