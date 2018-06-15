<?php
namespace jeyroik\extas\interfaces\systems\states;

use jeyroik\extas\interfaces\systems\IExtension;

/**
 * Interface IStatePlugin
 *
 * @package jeyroik\extas\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateExtension extends IExtension
{
    /**
     * @return string[]
     */
    public function getMethodsNames();
}
