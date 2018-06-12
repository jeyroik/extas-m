<?php
namespace tratabor\interfaces\systems\states;

use tratabor\interfaces\systems\IExtension;

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
