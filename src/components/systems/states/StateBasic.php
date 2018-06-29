<?php
namespace jeyroik\extas\components\systems\states;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\components\systems\SystemContainer;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\dispatchers\IDispatchersFactory;

/**
 * Class StateBasic
 *
 * @property string $id
 * @property string $fromState
 * @property array $additional
 * @property array $dispatchers
 *
 * @package jeyroik\extas\components\systems\states
 * @author Funcraft <me@funcraft.ru>
 */
class StateBasic extends Item implements IState
{
    /**
     * AState constructor.
     *
     * @param array|string $id
     * @param $fromState
     * @param $dispatchers
     * @param $additional
     */
    public function __construct($id, $fromState = '', $dispatchers = [], $additional = [])
    {
        $config = is_array($id)
            ? $id
            : [
                static::FIELD__ID => $id,
                static::FIELD__FROM_STATE => $fromState,
                static::FIELD__DISPATCHERS => $dispatchers,
                static::FIELD__ADDITIONAL => $additional
            ];

        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @param mixed $default
     *
     * @return array|mixed|null
     */
    public function getAdditional($name = '', $default = null)
    {
        $additional = $this->additional;

        return $name
            ? ($additional[$name] ?? $default)
            : $additional;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function setAdditional($name, $value)
    {
        $additional = $this->additional;
        $additional[$name] = $value;

        $this->additional = $additional;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromState(): string
    {
        return $this->fromState;
    }

    /**
     * @return \Generator|\jeyroik\extas\interfaces\systems\states\IStateDispatcher[]
     */
    public function getDispatchers()
    {
        /**
         * @var $factory IDispatchersFactory
         */
        $factory = SystemContainer::getItem(IDispatchersFactory::class);

        if (!$factory) {
            return [];
        }

        foreach ($this->dispatchers as $dispatcher) {
            yield $factory::buildDispatcher($dispatcher);
        }
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }

    /**
     * @param array $additional
     *
     * @return $this
     */
    protected function registerAdditional($additional)
    {
        if (!empty($additional)) {
            foreach ($additional as $name => $value) {
                $this->setAdditional($name, $value);
            }
        }

        return $this;
    }
}
