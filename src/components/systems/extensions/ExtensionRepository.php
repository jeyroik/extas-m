<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;
use jeyroik\extas\interfaces\systems\extensions\IExtensionRepository;
use jeyroik\extas\interfaces\systems\IExtension;
use MongoDB\Model\BSONDocument;

/**
 * Class ExtensionRepository
 *
 * @package jeyroik\extas\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionRepository extends RepositoryMongo implements IExtensionRepository
{
    protected $itemClass = Extension::class;
    protected $collectionName = 'extas__extensions';

    /**
     * @return IExtension|null
     */
    public function one()
    {
        $items = $this->where ? $this->collection->find($this->where)->toArray() : [];
        $this->reset();
        $item = count($items) ? array_shift($items) : [];

        if (!empty($item)) {
            $extensionClass = $item[IExtension::FIELD__CLASS];
            return new $extensionClass();
        }

        return null;
    }

    /**
     * @return array
     */
    public function all()
    {
        $items = [];

        if ($this->where) {
            $rows = $this->collection->find($this->where)->toArray();

            foreach ($rows as $item) {
                /**
                 * @var $item BSONDocument
                 */
                $item = $this->unSerializeItem($item);
                $extensionClass = $item[IExtension::FIELD__CLASS];
                $items[] = new $extensionClass();
            }
        }

        $this->reset();

        return $items;
    }
}
