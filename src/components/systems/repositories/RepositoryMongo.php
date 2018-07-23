<?php
namespace jeyroik\extas\components\systems\repositories;

use MongoDB\Model\BSONDocument;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\IRepository;

/**
 * Class RepositoryMongo
 *
 * @package jeyroik\extas\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
class RepositoryMongo extends RepositoryAbstract implements IRepository
{
    const CLAUSE__FIELD = 0;
    const CLAUSE__WHERE = 1;
    const CLAUSE__VALUE = 2;
    const CLAUSE__GLUE = 3;

    const FLAG__UPDATE = '$set';

    protected $collectionName = 'system';

    protected $collectionUID = 'id';
    protected $driverUID = '_id';

    /**
     * @var \MongoDB\Client
     */
    protected $driver = null;

    /**
     * @var \MongoDb\Driver\Cursor
     */
    protected $where = null;

    /**
     * @var \MongoDB\Collection
     */
    protected $collection = null;

    /**
     * @var string
     */
    protected $dsn = 'mongodb://localhost:27017';

    /**
     * RepositoryMongo constructor.
     * @param string $dsn
     */
    public function __construct($dsn = '')
    {
        $dsn && $this->setDsn($dsn);
        $this->initDriver();
    }

    /**
     * @param $item
     *
     * @return mixed
     * @throws \Exception
     */
    public function create($item)
    {
        if (is_object($item) && ($item instanceof IItem)) {
            $data = $item->__toArray();
        } elseif (is_array($item)) {
            $data = $item;
        } else {
            throw new \Exception('Unsupported item type "' . gettype($item) . '".');
        }

        $this->collection->insertOne($data);
        $itemClass = $this->getItemClass();

        return is_object($item) ? $item : new $itemClass($item);
    }

    /**
     * @param $item
     *
     * @return int
     */
    public function delete($item): int
    {
        if ($this->where) {
            $removed = $this->collection->deleteMany($this->where);
            $this->reset();

            return $removed->getDeletedCount();
        }

        return 0;
    }

    /**
     * @param $item
     *
     * @return int
     * @throws \Exception
     */
    public function update($item): int
    {
        if (is_object($item) && ($item instanceof IItem)) {
            $data = $item->__toArray();
        } elseif (is_array($item)) {
            $data = $item;
        } else {
            throw new \Exception('Unsupported item type "' . gettype($item) . '".');
        }

        $data = $this->prepareForUpdate($data);

        if ($this->where) {
            $updated = $this->collection->updateMany($this->where, $data);
            $this->reset();

            return $updated->getModifiedCount();
        } else {
            $uid = $data[static::FLAG__UPDATE][$this->collectionUID] ?? '';
            if (isset($data[static::FLAG__UPDATE][$this->driverUID])) {
                unset($data[static::FLAG__UPDATE][$this->driverUID]);
            }
            $this->collection->updateOne([$this->collectionUID => $uid], $data);
            return 1;
        }
    }

    /**
     * @return mixed
     */
    public function one()
    {
        $items = $this->where ? $this->collection->find($this->where)->toArray() : [];
        $item = count($items) ? array_shift($items) : [];

        $itemClass = $this->getItemClass();
        $this->reset();

        return empty($item) ? null : new $itemClass($this->unSerializeItem($item));
    }

    /**
     * @return array
     */
    public function all()
    {
        $items = [];
        $itemClass = $this->getItemClass();

        if ($this->where) {
            $rows = $this->collection->find($this->where)->toArray();

            foreach ($rows as $item) {
                /**
                 * @var $item BSONDocument
                 */
                $items[] = new $itemClass($this->unSerializeItem($item));
            }
        }

        $this->reset();

        return $items;
    }

    public function commit(): bool
    {
        return true;
    }

    /**
     * @param array $where
     *
     * @return IRepository
     */
    public function find($where = []): IRepository
    {
        if (!empty($where)) {
            $keys = array_keys($where);
            if (is_numeric($keys[0])) {
                $compositeWhere = 'function(){ return ';
                foreach ($where as $clause) {
                    $compositeWhere .= $this->buildCompositeWhere($clause);
                }
                $compositeWhere .= '}';
                $this->where = ['$where' => $compositeWhere];
            } else {
                $this->where = $where;
            }
        }

        return $this;
    }

    /**
     * @param $clause
     *
     * @return string
     */
    protected function buildCompositeWhere($clause)
    {
        $glue = $clause[static::CLAUSE__GLUE] ?? ';';

        $whereToMongo = [
            '=' => '==',
            'eq' => '==',
            'neq' => '!='
        ];

        list($field, $where, $value) = $clause;

        $field = 'this.' . $field;
        $where = $whereToMongo[$where] ?? $where;

        if (strpos($value, $this->getName() . '.') !== false) {
            $fieldName = explode('.', $value)[1];
            $value = 'this.' . $fieldName;
        } elseif (!is_numeric($value)) {
            $value = "'" . $value . "'";
        }

        return $field . ' ' . $where . ' ' . $value . $glue;
    }

    /**
     * @param $item
     *
     * @return array
     */
    protected function prepareForUpdate($item)
    {
        return [static::FLAG__UPDATE => $item];
    }

    /**
     * @param $item
     *
     * @return array
     */
    protected function unSerializeItem($item)
    {
        $unSerialized = [];

        $item = (array) $item;

        foreach ($item as $field => $value) {
            if (is_object($value)) {
                $value = $this->unSerializeItem($value);
            }

            $unSerialized[$field] = $value;
        }

        return $unSerialized;
    }

    /**
     * @return $this
     */
    protected function reset()
    {
        $this->where = [];

        return $this;
    }

    /**
     * @return $this
     */
    protected function initCollection()
    {
        if ($this->collection) {
            return $this;
        }

        $collectionName = $this->collectionName;
        $this->collection = $this->driver->g5->$collectionName;

        return $this;
    }

    protected function initDriver()
    {
        $this->driver = new \MongoDB\Client($this->dsn);
        $this->initCollection();

        return $this;
    }
}
