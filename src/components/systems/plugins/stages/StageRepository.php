<?php
namespace jeyroik\extas\components\systems\plugins\stages;

use jeyroik\extas\components\systems\plugins\PluginStage;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;
use jeyroik\extas\interfaces\systems\plugins\stages\IStageRepository;

/**
 * Class StageRepository
 *
 * @package jeyroik\extas\components\systems\plugins\stages
 * @author Funcraft <me@funcraft.ru>
 */
class StageRepository extends RepositoryMongo implements IStageRepository
{
    protected $itemClass = PluginStage::class;
    protected $collectionName = 'extas__stages';
}
