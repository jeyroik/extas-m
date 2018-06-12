<?php
namespace tratabor\components\systems\states;

use tratabor\components\systems\plugins\TPluginAcceptable;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\plugins\IPluginRepository;
use tratabor\interfaces\systems\states\dispatchers\IDispatchersFactory;
use tratabor\interfaces\systems\IExtension;
use tratabor\interfaces\systems\states\IStateExtension;

/**
 * Class StateBasic
 *
 * @sm-stage-interface state__created(IState &$state): void
 * @sm-stage-interface state__ext_method_call(IState $state, string $methodName, array $arguments): array $arguments
 * @sm-stage-interface state__destructed(IState &$state): void
 *
 * @package tratabor\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateBasic implements IState
{
    const STAGE__CREATED = 'state__created';
    const STAGE__DESTRUCTED = 'state__destructed';

    use TPluginAcceptable;

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var string
     */
    protected $fromState = '';

    /**
     * @var array
     */
    protected $dispatchers = [];

    /**
     * @var int
     */
    protected $createdAt = 0;

    /**
     * @var IStateExtension[]
     */
    protected $registeredInterfaces = [];

    /**
     * @var array
     */
    protected $extendedMethodToInterface = [];

    /**
     * @var array
     */
    protected $pluginsByStage = [];

    /**
     * @var array
     */
    protected $additional = [];

    /**
     * AState constructor.
     *
     * @param $id
     * @param $fromState
     * @param $dispatchers
     * @param $additional
     */
    public function __construct($id, $fromState, $dispatchers = [], $additional = [])
    {
        $this->setId($id)
            ->setFromState($fromState)
            ->setCreatedAt()
            ->setDispatchers($dispatchers)
            ->registerAdditional($additional)
            ->registerPlugins($this->getAdditional(static::FIELD__PLUGINS))
            ->triggerCreated();
    }

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
            $interfaceRealization = $this->registeredInterfaces[$this->extendedMethodToInterface[$name]];

            foreach ($this->getPluginsByStage(static::STAGE__EXTENDED_METHOD_CALL) as $plugin) {
                $arguments = $plugin($this, $name, $arguments);
            }

            return $interfaceRealization->runMethod($this, $name, $arguments);
        }

        throw new \Exception('Call unknown or unregistered method "' . $name . '".');
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        $basic = [
            'id' => $this->getId(),
            'fromState' => $this->getFromState(),
            'created_at' => $this->getCreatedAt(),
            'dispatchers' => $this->getDispatchers(),
        ];

        $result = (array) ($basic + $this->getAdditional());

        return $result;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return array|mixed|null
     */
    public function getAdditional($name = '')
    {
        return $name
            ? ($this->additional[$name] ?? null)
            : $this->additional;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function setAdditional($name, $value)
    {
        $this->additional[$name] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromState(): string
    {
        return $this->fromState;
    }

    /**
     * @param string $format
     *
     * @return false|int|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->createdAt) : $this->createdAt;
    }

    /**
     * @return \Generator|\tratabor\interfaces\systems\states\IStateDispatcher[]
     */
    public function getDispatchers()
    {
        /**
         * @var $factory IDispatchersFactory
         */
        $factory = SystemContainer::getItem(IDispatchersFactory::class);

        if (!$factory) {
            return [];
        }

        foreach ($this->dispatchers as $dispatcher) {
            yield $factory::buildDispatcher($dispatcher);
        }
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
     * @param array $additional
     *
     * @return $this
     */
    protected function registerAdditional($additional)
    {
        if (!empty($additional)) {
            foreach ($additional as $name => $value) {
                $this->setAdditional($name, $value);
            }
        }

        return $this;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    protected function setId($id)
    {
        $this->id = (string) $id;

        return $this;
    }

    /**
     * @param string $fromState
     *
     * @return $this
     */
    protected function setFromState($fromState)
    {
        $this->fromState = (string) $fromState;

        return $this;
    }

    /**
     * @param mixed[] $dispatchers
     *
     * @return $this
     */
    protected function setDispatchers($dispatchers)
    {
        $this->dispatchers = is_array($dispatchers) ? $dispatchers : [$dispatchers];

        return $this;
    }

    /**
     * @return $this
     */
    protected function setCreatedAt()
    {
        $this->createdAt = time();

        return $this;
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
