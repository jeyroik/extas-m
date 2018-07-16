<?php
namespace jeyroik\extas\interfaces\systems\plugins;

/**
 * Interface IPluginStage
 *
 * @package jeyroik\extas\interfaces\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
interface IPluginStage
{
    const FIELD__NAME = 'name';
    const FIELD__DESCRIPTION = 'description';
    const FIELD__INPUT = 'input';
    const FIELD__OUTPUT = 'output';

    const ARG__TYPE = 'type';
    const ARG__NAME = 'arg';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getInput(): string;

    /**
     * @return string
     */
    public function getOutput(): string;

    /**
     * @return array
     */
    public function getInputAsArray(): array;

    /**
     * @return array
     */
    public function getOutputAsArray(): array;
}
