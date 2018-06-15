<?php
namespace tratabor\components\systems;

use League\Container\Container;
use tratabor\interfaces\systems\IContainer;

/**
 * Class SystemContainer
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class SystemContainer implements IContainer
{
    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var Container
     */
    protected $container = null;

    /**
     * @param string $name
     *
     * @return mixed|object
     */
    public static function getItem($name)
    {
        return static::getInstance()->get($name);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * SystemContainer constructor.
     *
     * @throws \Exception
     */
    protected function __construct()
    {
        $containerConfigPath = getenv('G5__CONTAINER_PATH')
            ?: G5__ROOT_PATH . '/resources/configs/container.php';

        if (is_file($containerConfigPath)) {
            $this->container = new Container();
            $containerConfig = include $containerConfigPath;

            foreach ($containerConfig as $itemName => $itemValue) {
                $this->container->add($itemName, $itemValue);
            }
        } else {
            throw new \Exception(
                'Missed or restricted container config path "' . $containerConfigPath . '".'
            );
        }
    }

    /**
     * @param $name
     *
     * @return mixed|object
     */
    public function get($name)
    {
        return $this->container->get($name);
    }
}
