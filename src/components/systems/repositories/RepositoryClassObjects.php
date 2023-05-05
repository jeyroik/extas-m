<?php
namespace jeyroik\extas\components\systems\repositories;

use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\items\IItemClassObject;

/**
 * Class RepositoryClassObjects
 *
 * @package jeyroik\extas\components\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
class RepositoryClassObjects extends RepositoryMongo
{
    /**
     * @return null|mixed
     */
    public function one()
    {
        /**
         * @var $model IItemClassObject|IItem
         */
        $model = parent::one();

        if ($model) {
            $className = $model->getClass();
            return new $className($model->__toArray());
        }

        return null;
    }

    /**
     * @return array
     */
    public function all()
    {
        /**
         * @var $models IItemClassObject[]|IItem[]
         */
        $models = parent::all();
        $real = [];

        if (!empty($models)) {
            foreach ($models as $model) {
                $className = $model->getClass();
                $real[] = new $className($model->__toArray());
            }
        }

        return $real;
    }
}
