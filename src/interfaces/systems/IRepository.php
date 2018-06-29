<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IRepository
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IRepository
{
    /**
     * @return IRepository
     */
    public function connect(): IRepository;

    /**
     * @param $item
     *
     * @return mixed
     */
    public function create($item);

    /**
     * @param $item
     *
     * @return int count of updated items
     */
    public function update($item): int;

    /**
     * @param $item
     *
     * @return int count of deleted items
     */
    public function delete($item): int;

    /**
     * @param array $where
     *
     * @return IRepository
     */
    public function find($where = []): IRepository;

    /**
     * @return mixed
     */
    public function one();

    /**
     * @return array
     */
    public function all();

    /**
     * @param $dsn
     *
     * @return IRepository
     */
    public function setDsn($dsn): IRepository;

    /**
     * @return string
     */
    public function getDsn(): string;

    /**
     * @param $itemClass
     *
     * @return IRepository
     */
    public function setItemClass($itemClass): IRepository;

    /**
     * @return string
     */
    public function getItemClass(): string;

    /**
     * @return bool
     */
    public function commit(): bool;

    /**
     * @return string
     */
    public function getName(): string;
}
