<?php
namespace jeyroik\extas\components\systems\repositories;

use jeyroik\extas\interfaces\systems\IRepository;

/**
 * Class RepositoryAbstract
 *
 * @package jeyroik\extas\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
abstract class RepositoryAbstract implements IRepository
{
    /**
     * @var string
     */
    protected $dsn = '';

    /**
     * @var string
     */
    protected $itemClass = '';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $where = [];

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @return IRepository
     *
     * @throws \Exception
     */
    public function connect(): IRepository
    {
        if (empty($this->dsn)) {
            throw new \Exception('Empty DSN. Please define dsn to use this storage');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $where
     *
     * @return IRepository
     */
    public function find($where = []): IRepository
    {
        $this->where = $where;

        return $this;
    }

    /**
     * @param $itemClass
     *
     * @return IRepository
     */
    public function setItemClass($itemClass): IRepository
    {
        $this->itemClass = $itemClass;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemClass(): string
    {
        return $this->itemClass;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @param $dsn
     *
     * @return IRepository
     */
    public function setDsn($dsn): IRepository
    {
        $this->dsn = $dsn;

        return $this;
    }
}
