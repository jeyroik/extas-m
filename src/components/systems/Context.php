<?php
namespace jeyroik\extas\components\systems;

use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class Context
 *
 * @package jeyroik\extas\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Context extends Item implements IContext
{
    /**
     * @var array
     */
    private $readOnly = [];

    /**
     * Context constructor.
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
        if (is_object($data) && ($data instanceof IContext)) {
            $data = $data->__toArray();
        }

        parent::__construct($data);
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setReadOnly($name)
    {
        $this->readOnly[$name] = true;

        return $this;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function isReadOnly($name)
    {
        return isset($this->readOnly[$name]);
    }

    /**
     * @param mixed $name
     *
     * @throws \Exception
     */
    public function offsetUnset($name)
    {
        if ($this->isReadOnly($name)) {
            throw new \Exception('Access restricted for the item "' . $name . '".');
        }

        parent::offsetUnset($name);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     *
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset) && $this->isReadOnly($offset)) {
            throw new \Exception('Access restricted for the item "' . $offset . '".');
        }

        parent::offsetSet($offset, $value);
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
