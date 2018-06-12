<?php
namespace tratabor\components\systems\states\dispatchers;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;

/**
 * Class DispatcherError
 *
 * todo: log an error
 *
 * @package tratabor\components\systems\states\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherError implements IStateDispatcher
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
    }

    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $context->updateItem('success', false);

        return $context;
    }
}
