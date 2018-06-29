<?php
namespace jeyroik\extas\components\systems\states\machines\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class ExtensionContextErrors
 *
 * @package jeyroik\extas\components\systems\states\machines\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionContextErrors extends Extension
{
    const CONTEXT__ITEM__ERRORS = '@directive.errors()';

    protected $methods = [
        'addError' => ExtensionContextErrors::class
    ];

    /**
     * @param mixed $error
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function addError($error, IContext &$context = null)
    {
        if (!isset($context[static::CONTEXT__ITEM__ERRORS])) {
            $context[static::CONTEXT__ITEM__ERRORS] = [];
        }

        $errors = $context[static::CONTEXT__ITEM__ERRORS];
        $errors[] = $error;

        $context[static::CONTEXT__ITEM__ERRORS] = $errors;

        return $context;
    }
}
