<?php
namespace jeyroik\extas\components\systems\states\dispatchers;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class DispatcherError
 *
 * todo: log an error
 *
 * @package jeyroik\extas\components\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherError extends DispatcherAbstract implements IStateDispatcher
{
    /**
     * @var \Exception|null
     */
    protected $error = null;

    /**
     * DispatcherError constructor.
     * @param \Exception $e
     */
    public function __construct(\Exception $e)
    {
        $this->error = $e;

        parent::__construct();
    }

    protected function dispatch(IContext $context): IContext
    {
        $context[PluginInitContextSuccess::CONTEXT__SUCCESS] = false;

        return $context;
    }
}
