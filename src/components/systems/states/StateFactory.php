<?php
namespace jeyroik\extas\components\systems\states;

use jeyroik\extas\components\systems\extensions\TExtendable;
use jeyroik\extas\components\systems\plugins\TPluginAcceptable;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use jeyroik\extas\interfaces\systems\states\IStateFactory;

/**
 * Class StateFactory
 *
 * State config:
 * [
 *      'id' => '',
 *      'dispatchers' => [...], // see DispatcherFactory for details
 * ]
 *
 * @sm-stage-interface after_state_build(IState $state): IState
 *
 * @package jeyroik\extas\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateFactory implements IStateFactory
{
    use TPluginAcceptable;
    use TExtendable;

    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $states = [];

    /**
     * @var string
     */
    protected $stateClass = StateBasic::class;

    protected static $plugins = [];

    /**
     * @param $plugins
     *
     * @return bool
     */
    public static function injectPlugins($plugins)
    {
        static::$plugins += $plugins;

        return true;
    }

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState
    {
        return static::getInstance()->build($stateConfig, $fromState, $stateId);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * StateFactory constructor.
     */
    public function __construct()
    {
        $this->registerPlugins(static::$plugins);
    }

    /**
     * @param string $stateClass
     *
     * @return $this
     */
    public function setStateClass($stateClass)
    {
        $this->stateClass = $stateClass;

        return $this;
    }

    /**
     * @param $stateConfig
     * @param $fromState
     * @param $stateId
     *
     * @return IState
     */
    public function build($stateConfig, $fromState, $stateId)
    {
        $stateClass = $this->stateClass;
        $stateDispatchers = $stateConfig['dispatchers'] ?? [];

        $state = new $stateClass(
            $stateId,
            $fromState,
            $stateDispatchers,
            $stateConfig
        );

        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage(
            static::class,
            static::STAGE__AFTER_STATE_BUILD) as $plugin
        ) {
            $state = $plugin($state);
        }

        return $state;
    }
}
