<?php

namespace Simples\Data;

/**
 * Class Validation
 * @package Simples\Data
 */
class Validation
{
    /**
     * @var array
     */
    private $rules = [];

    /**
     * Validation constructor.
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->rules = $rules;
    }

    /**
     * @param $field
     * @param $value
     * @param array ...$arguments
     * @return $this
     */
    public function add($field, $value, ...$arguments)
    {
        $rules = [];
        foreach ($arguments as $argument) {
            if (type($argument, TYPE_STRING)) {
                $rules[$argument] = '';
                continue;
            }
            if (!type($argument, TYPE_ARRAY)) {
                continue;
            }
            foreach ($argument as $rule => $options) {
                $rules[$rule] = $options;
            }
        }
        $this->rules[$field] = ['rules' => $rules, 'value' => $value];

        return $this;
    }

    /**
     * @param $field
     * @param $value
     * @param array ...$arguments
     * @return Validation
     */
    public function set($field, $value, ...$arguments)
    {
        return $this->add($field, $value, $arguments);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->rules;
    }
}
