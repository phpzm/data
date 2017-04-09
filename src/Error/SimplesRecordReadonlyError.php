<?php

namespace Simples\Data\Error;

use Simples\Error\SimplesRunTimeError;

/**
 * Class SimplesRecordReadonlyError
 * @package Simples\Data\Error
 */
class SimplesRecordReadonlyError extends SimplesRunTimeError
{
    /**
     * @var int
     */
    protected $status = 500;

    /**
     * ResourceError constructor.
     * @param array $details
     */
    public function __construct(array $details = [])
    {
        parent::__construct('Record is readonly', $details);
    }

}
