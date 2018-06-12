<?php
namespace tratabor\interfaces\systems\states;

/**
 * Interface IStatePlugin
 *
 * @package tratabor\interfaces\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
interface IStateExtension extends IExtension
{
    /**
     * @return string[]
     */
    public function getMethodsNames();
}
