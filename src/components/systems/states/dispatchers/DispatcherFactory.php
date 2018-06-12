<?php
namespace tratabor\components\systems\states\dispatchers;

use tratabor\interfaces\systems\states\dispatchers\IDispatchersFactory;
use tratabor\interfaces\systems\states\IStateDispatcher;

/**
 * Class DispatcherFactory
 *
 * @package tratabor\components\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherFactory implements IDispatchersFactory
{
    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var IStateDispatcher[]
     */
    protected $dispatchers = [];

    /**
     * @param $dispatcherConfig
     * @param null $dispatcherId
     *
     * @return mixed|IStateDispatcher
     */
    public static function buildDispatcher($dispatcherConfig, $dispatcherId = null)
    {
        return static::getInstance()->build($dispatcherConfig, $dispatcherId);
    }

    /**
     * @param $dispatcherConfig
     * @param string $dispatcherId
     *
     * @return bool
     */
    public static function registerDispatcher($dispatcherConfig, $dispatcherId): bool
    {
        static::buildDispatcher($dispatcherConfig, $dispatcherId);

        return true;
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * @param string|callable|array $dispatcherConfig
     * @param string $dispatcherId
     * @param array $arguments
     *
     * @return IStateDispatcher|callable
     */
    public function build($dispatcherConfig, $dispatcherId = '', $arguments = [])
    {
        if (is_callable($dispatcherConfig)) {
            return $dispatcherConfig;
        }

        if (is_string($dispatcherConfig)) {

            $dispatcherId = $dispatcherId ?: $dispatcherConfig;
            if (isset($this->dispatchers[$dispatcherId])) {
                return $this->dispatchers[$dispatcherId];
            }

            try {
                $this->dispatchers[$dispatcherId] = new $dispatcherConfig($arguments);
            } catch (\Exception $e) {
                $this->dispatchers[$dispatcherId] = new DispatcherError($e);
            }

        } elseif (is_array($dispatcherConfig)) {

            $dispatcherId = $dispatcherId ?: sha1(json_encode($dispatcherConfig));
            if (isset($this->dispatchers[$dispatcherId])) {
                return $this->dispatchers[$dispatcherId];
            }

            if (!isset($dispatcherConfig['class'])) {
                return $this->build(
                    DispatcherError::class,
                    $dispatcherId,
                    new \Exception('Missed "class" param in a state dispatcher config.')
                );
            } else {
                $args = $dispatcherConfig['args'] ?? $dispatcherConfig;
                return $this->build($dispatcherConfig['class'], $dispatcherId, $args);
            }

        } else {
            $dispatcherId = serialize($dispatcherConfig);
            return $this->build(
                DispatcherError::class,
                $dispatcherId,
                new \Exception('Unsupported state dispatcher type "' . gettype($dispatcherConfig) . '".')
            );
        }

        return $this->dispatchers[$dispatcherId];
    }
}
