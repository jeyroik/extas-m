<?php
namespace jeyroik\extas\components\systems\states;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateFactory;

/**
 * Class StateFactory
 *
 * @package jeyroik\extas\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateFactory extends Item implements IStateFactory
{
    /**
     * @var static
     */
    protected static $instance = null;

    /**
     * @var array
     */
    protected $states = [];

    /**
     * @var string
     */
    protected $stateClass = StateBasic::class;

    /**
     * @param $stateConfig
     * @param string $fromState
     * @param string $stateId
     *
     * @return IState
     */
    public static function buildState($stateConfig, $fromState, $stateId = null): IState
    {
        return static::getInstance()->build($stateConfig, $fromState, $stateId);
    }

    /**
     * @return static
     */
    protected static function getInstance()
    {
        return self::$instance ?: self::$instance = new static();
    }

    /**
     * @param string $stateClass
     *
     * @return $this
     */
    public function setStateClass($stateClass)
    {
        $this->stateClass = $stateClass;

        return $this;
    }

    /**
     * @param $stateConfig
     * @param $fromState
     * @param $stateId
     *
     * @return IState
     */
    public function build($stateConfig, $fromState, $stateId)
    {
        $stateClass = $this->stateClass;
        $stateDispatchers = $stateConfig[IState::FIELD__DISPATCHERS] ?? [];

        return new $stateClass(
            $stateId,
            $fromState,
            $stateDispatchers,
            $stateConfig
        );
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
