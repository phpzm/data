<?php

namespace Simples\Data\Validators;

use Simples\Helper\Date;
use Simples\Helper\Datetime;
use Simples\Helper\Time;

/**
 * Class DateValidator
 * @package Simples\Data\Validators
 */
trait DateValidator
{
    /**
     * @param $value
     * @return bool
     */
    public function isDate($value)
    {
        return Date::isValid($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isDatetime($value)
    {
        return Datetime::isValid($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isTime($value)
    {
        return Time::isValid($value);
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
