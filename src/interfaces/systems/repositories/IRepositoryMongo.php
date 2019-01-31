<?php
namespace jeyroik\extas\interfaces\systems\repositories;

use jeyroik\extas\interfaces\systems\IRepository;

/**
 * Interface IRepositoryMongo
 *
 * @package jeyroik\extas\interfaces\systems\repositories
 * @author Funcraft <me@funcraft.ru>
 */
interface IRepositoryMongo extends IRepository
{
    /**
     * @param $fields
     * @param array $options
     *
     * @return array
     */
    public function group($fields, $options = []);
}
