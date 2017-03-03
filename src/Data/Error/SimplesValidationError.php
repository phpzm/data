<?php

namespace Simples\Data\Error;

use Simples\Error\SimplesRunTimeError;

/**
 * Class ValidationError
 * @package Simples\Data\Error
 */
class SimplesValidationError extends SimplesRunTimeError
{
    /**
     * @var int
     */
    protected $status = 400;

    /**
     * ValidationError constructor.
     * @param array $details
     * @param string $message
     */
    public function __construct(array $details = [], string $message = '')
    {
        parent::__construct('Validation error' . ($message ? 'in `' . $message . '`' : ''), $details);
    }
}
