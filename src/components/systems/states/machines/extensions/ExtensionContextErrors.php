<?php
namespace jeyroik\extas\components\systems\states\machines\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\contexts\IContextErrors;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class ExtensionContextErrors
 *
 * @package jeyroik\extas\components\systems\states\machines\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ExtensionContextErrors extends Extension implements IContextErrors
{
    const CONTEXT__ITEM__ERRORS = '@directive.errors()';

    public $methods = [
        'addError' => ExtensionContextErrors::class
    ];

    public $subject = IContext::SUBJECT;

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
