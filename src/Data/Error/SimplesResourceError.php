<?php

namespace Simples\Data\Error;

use Simples\Error\SimplesRunTimeError;

/**
 * Class ResourceError
 * @package Simples\Data\Error
 */
class SimplesResourceError extends SimplesRunTimeError
{
    /**
     * @var int
     */
    protected $status = 410;

    /**
     * ResourceError constructor.
     * @param array $details
     */
    public function __construct(array $details = [])
    {
        parent::__construct('Resource error', $details);
    }
}
