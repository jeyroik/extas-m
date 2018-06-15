<?php
namespace tratabor\components\systems;

use tratabor\components\systems\extensions\TExtendable;
use tratabor\components\systems\plugins\TPluginAcceptable;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IItem;

/**
 * Class Context
 *
 * @package tratabor\components\systems
 * @author Funcraft <me@funcraft.ru>
 */
class Context extends Extension implements IContext
{
    use TPluginAcceptable;
    use TExtendable;

    protected const ITEM__SELF = 'item';
    protected const ITEM__MODE = 'mode';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * Context constructor.
     * @param $data
     *
     * @throws \Exception
     */
    public function __construct($data)
    {
        if (is_object($data) && ($data instanceof IContext)) {
            $this->items = $data->readAllItems();
        } else {
            foreach ($data as $key => $value) {
                $this->pushItemByName($key, $value);
            }
        }
    }

    /**
     * @param $name
     *
     * @return bool
     * @throws \Exception
     */
    public function removeItem($name): bool
    {
        if (!isset($this->items[$name])) {
            throw new \Exception('Unknown item "' . $name . '".');
        }

        if ($this->isWritable($name)) {
            unset($this->items[$name]);
        } else {
            throw new \Exception('Access restricted for the item "' . $name . '".');
        }

        return true;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasItem($name): bool
    {
        return isset($this->items[$name]);
    }

    /**
     * @param $name
     *
     * @return IItem
     * @throws \Exception
     */
    public function readItem($name): IItem
    {
        if (!isset($this->items[$name])) {
            throw new \Exception('Unknown item "' . $name . '".');
        }

        return $this->items[$name][static::ITEM__SELF];
    }

    /**
     * @return array
     */
    public function readAllItems()
    {
        return $this->items;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return IItem
     * @throws \Exception
     */
    public function updateItem($name, $value): IItem
    {
        if (!isset($this->items[$name])) {
            throw new \Exception('Unknown item "' . $name . '".');
        }

        if ($this->isWritable($name)) {
            $this->items[$name][static::ITEM__SELF]->setValue($value);
        } else {
            throw new \Exception('Access restricted for the item "' . $name . '".');
        }

        return $this->items[$name][static::ITEM__SELF];
    }

    /**
     * @param IItem $item
     * @param int $mode
     *
     * @return mixed|IItem
     * @throws \Exception
     */
    public function createItem(IItem $item, $mode = 1)
    {
        if (isset($this->items[$item->getKey()])) {
            throw new \Exception('Item "' . $item->getKey() . '" is already exists');
        }

        $this->items[$item->getKey()] = [
            static::ITEM__SELF => $item,
            static::ITEM__MODE => $mode
        ];

        return $item;
    }

    /**
     * @param $itemName
     * @param $itemValue
     *
     * @return mixed|IItem
     * @throws \Exception
     */
    public function pushItemByName($itemName, $itemValue)
    {
        $item = new Item($itemName, $itemValue);

        return $this->createItem($item, static::MODE__READ_WRITE);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    protected function isWritable($name)
    {
        return $this->items[$name][static::ITEM__MODE] > 0;
    }
}
