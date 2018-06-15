<?php
namespace jeyroik\extas\interfaces\systems;

/**
 * Interface IPlugin
 *
 * @package jeyroik\extas\interfaces\systems
 * @author Funcraft <me@funcraft.ru>
 */
interface IPlugin
{
    const FIELD__CLASS = 'class';
    const FIELD__VERSION = 'version';
    const FIELD__STAGE = 'stage';

    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return mixed
     */
    public function getVersion();

    /**
     * @return string
     */
    public function getStage(): string;
}
