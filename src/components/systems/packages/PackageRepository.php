<?php
namespace jeyroik\extas\components\systems\packages;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;
use jeyroik\extas\interfaces\systems\packages\IPackageRepository;

/**
 * Class PackageRepository
 *
 * @package jeyroik\extas\components\systems\packages
 * @author Funcraft <me@funcraft.ru>
 */
class PackageRepository extends RepositoryMongo implements IPackageRepository
{
    protected $itemClass = CrawlerPackage::class;
    protected $collectionName = 'extas__packages';
}
