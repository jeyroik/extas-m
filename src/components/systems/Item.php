<?php
namespace jeyroik\extas\components\systems;

use jeyroik\extas\components\systems\extensions\TExtendable;
use jeyroik\extas\components\systems\states\machines\TMachineAvailable;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IRepository;
use jeyroik\extas\interfaces\systems\states\machines\IMachineAvailable;

/**
 * Class Item
 *
 * @property $id
 * @property int $created_at
 * @property int $updated_at
 *
 * @package jeyroik\extas\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
abstract class Item implements IItem, IMachineAvailable
{
    use TMachineAvailable;
    use TExtendable;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var int
     */
    protected $currentKey = 0;

    /**
     * @var array
     */
    protected $keyMap = [];

    /**
     * Item constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setConfig($config)->triggerInit();
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        foreach ($this->getPluginsByStage($this->getSubjectForExtension() . '.after') as $plugin) {
            $plugin($this);
        }
    }

    /**
     * @param string $format
     *
     * @return false|int|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->created_at) : $this->created_at;
    }

    /**
     * @param string $format
     *
     * @return false|int|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->updated_at) : $this->updated_at;
    }


    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->config;
    }

    /**
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->config[$name] ?? null;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->config[$name] = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->id;
    }

    /**
     * @return int
     */
    public function __toInt(): int
    {
        return (int) $this->id;
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
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->config[$offset] ?? null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->config[$offset] = null;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->keyMap[$this->currentKey]);
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->currentKey;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->currentKey++;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->config[$this->keyMap[$this->currentKey]];
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentKey = 0;
    }

    /**
     * @param $item
     * @param $repo IRepository
     *
     * @return $this|IItem
     */
    public function __created($item, $repo)
    {
        foreach ($this->getPluginsByStage($this->getSubjectForExtension() . '.created') as $plugin) {
            $plugin($this, $item, $repo);
        }

        return $this;
    }

    /**
     * @param $config
     *
     * @return IItem|mixed
     */
    protected function setConfig($config)
    {
        !empty($config) && $this->config = $config;
        $this->keyMap = array_keys($config);
        $this->currentKey = 0;

        return $this;
    }

    /**
     * @return $this
     */
    protected function triggerInit()
    {
        foreach ($this->getPluginsByStage($this->getSubjectForExtension() . '.init') as $plugin) {
            $plugin($this);
        }

        return $this;
    }
}