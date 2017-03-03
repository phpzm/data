<?php

namespace Simples\Data\Validators;

/**
 * Class FileValidator
 * @package Simples\Data\Validators
 */
trait FileValidator
{
    /**
     * @param $value
     * @return mixed
     */
    public function isFile($value)
    {
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isImage($value)
    {
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isMimes($value)
    {
        // :[jpeg,png,bmp,gif,svg(...)]
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isMimetypes($value)
    {
        // :[text/plain(...)]
        return $value;
    }
}
