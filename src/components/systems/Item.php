<?php
namespace tratabor\components\systems;

use tratabor\components\systems\states\machines\TMachineAvailable;
use tratabor\components\systems\states\TStateAvailable;
use tratabor\interfaces\systems\IItem;
use tratabor\interfaces\systems\states\IStateAvailable;
use tratabor\interfaces\systems\states\machines\IMachineAvailable;

/**
 * Class Item
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Item implements IItem, IMachineAvailable, IStateAvailable
{
    use TMachineAvailable;
    use TStateAvailable;

    /**
     * @var string
     */
    protected $key = null;

    /**
     * @var string
     */
    protected $value = null;

    /**
     * @var string
     */
    protected $id = '';

    /**
     * @var int
     */
    protected $createdAt = 0;

    /**
     * @var int
     */
    protected $updatedAt = 0;

    /**
     * Item constructor.
     *
     * @param $key
     * @param $value
     * @param string $id
     * @param string $state
     * @param int $createdAt
     * @param int $updatedAt
     */
    public function __construct($key, $value, $id = '', $state = 'created', $createdAt = 0, $updatedAt = 0)
    {
        $this->setKey($key)
            ->setValue($value)
            ->setId($id)
            ->setState($state)
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt);
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return (string) $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->getCurrentStateId();
    }

    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $format
     *
     * @return false|int|string
     */
    public function getCreatedAt($format = '')
    {
        return $format ? date($format, $this->createdAt) : $this->createdAt;
    }

    /**
     * @param string $format
     *
     * @return false|int|string
     */
    public function getUpdatedAt($format = '')
    {
        return $format ? date($format, $this->updatedAt) : $this->updatedAt;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        $this->setState('updated')->setUpdatedAt();

        return $this;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        $value = $this->getValue();

        if (is_object($value) && ($value instanceof IItem)) {
            $value = $value->__toArray();
        }

        return [
            'id' => $this->getId(),
            'key' => $this->getKey(),
            'value' => $value,
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }

    /**
     * @param $key
     *
     * @return $this
     */
    protected function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param $id
     *
     * @return $this
     */
    protected function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param $state
     *
     * @return $this
     */
    protected function setState($state)
    {
        $this->setCurrentState($state);

        return $this;
    }

    /**
     * @param int $createdAt
     *
     * @return $this
     */
    protected function setCreatedAt($createdAt = 0)
    {
        $this->createdAt = $createdAt ?: time();

        return $this;
    }

    /**
     * @param int $updatedAt
     *
     * @return $this
     */
    protected function setUpdatedAt($updatedAt = 0)
    {
        $this->updatedAt = $updatedAt ?: time();

        return $this;
    }
}
