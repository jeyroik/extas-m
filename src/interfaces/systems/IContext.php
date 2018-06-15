<?php
namespace tratabor\interfaces\systems;

/**
 * Interface IContext
 *
 * @package tratabor\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IContext extends IPluginsAcceptable, IExtendable
{
    const MODE__READ_ONLY = -1;
    const MODE__READ_WRITE = 1;

    /**
     * IContext constructor.
     *
     * @param $data
     */
    public function __construct($data);

    /**
     * @param $itemName
     * @param $itemValue
     *
     * @return mixed
     */
    public function pushItemByName($itemName, $itemValue);

    /**
     * @param IItem $item
     * @param int $mode -1: readonly, 1: read/write
     *
     * @return mixed
     */
    public function createItem(IItem $item, $mode = 1);

    /**
     * @param $name
     *
     * @return IItem
     */
    public function readItem($name): IItem;

    /**
     * @param $name
     * @param $value
     *
     * @return IItem
     */
    public function updateItem($name, $value): IItem;

    /**
     * @param $name
     *
     * @return bool
     */
    public function removeItem($name): bool;

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasItem($name): bool;

    /**
     * @return array
     */
    public function readAllItems();
}
