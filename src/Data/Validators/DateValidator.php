<?php

namespace Simples\Data\Validators;

use Simples\Helper\Date;

/**
 * Class DateValidator
 * @package Simples\Data\Validators
 */
trait DateValidator
{
    /**
     * @param $value
     * @return mixed
     */
    public function isDate($value)
    {
        return Date::isDate($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isDateFormat($value)
    {
        // :format
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isTimezone($value)
    {
        return $value;
    }
}
