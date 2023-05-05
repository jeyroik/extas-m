<?php
namespace jeyroik\extas\components\systems\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\components\systems\repositories\RepositoryClassObjects;
use jeyroik\extas\interfaces\systems\extensions\IExtensionRepository;

/**
 * Class ExtensionRepository
 *
 * @package jeyroik\extas\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionRepository extends RepositoryClassObjects implements IExtensionRepository
{
    protected $itemClass = Extension::class;
    protected $collectionName = 'extas__extensions';
    protected $collectionUID = Extension::FIELD__CLASS;
}
