<?php
namespace jeyroik\extas\components\systems\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\components\systems\repositories\RepositoryClassObjects;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;

/**
 * Class PluginRepository
 *
 * @package jeyroik\extas\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginRepository extends RepositoryClassObjects implements IPluginRepository
{
    protected $itemClass = Plugin::class;
    protected $collectionName = 'extas__plugins';
}
