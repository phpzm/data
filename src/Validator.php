<?php

namespace Simples\Data;

use Simples\Data\Validators\DatabaseValidator;
use Simples\Data\Validators\DateValidator;
use Simples\Data\Validators\FileValidator;
use Simples\Data\Validators\LogicalValidator;
use Simples\Data\Validators\NumberValidator;
use Simples\Data\Validators\StringValidator;
use Simples\Helper\JSON;

/**
 * Class Validator
 * @package Simples\Data
 */
class Validator
{
    use DateValidator, StringValidator, NumberValidator, LogicalValidator, FileValidator,
        DatabaseValidator;

    /**
     * @var string
     */
    const
        ACCEPTED = 'accepted', ACTIVE = 'active', AFTER = 'after', ALPHA = 'alpha', ALPHA_DASH = 'alpha-dash',
        ALPHA_NUMERIC = 'alpha-numeric', BEFORE = 'before', BETWEEN = 'between', BOOLEAN = 'boolean',
        CONFIRMED = 'confirmed', DATE = 'date', DATE_FORMAT = 'date-format', DIFFERENT = 'different', DIGITS = 'digits',
        DIGITS_BETWEEN = 'digits-between', DIMENSIONS = 'dimensions', DISTINCT = 'distinct', EMAIL = 'email',
        EXISTING = 'existing', FILE = 'file', FILLED = 'filled', IMAGE = 'image', IN = 'in', IN_ARRAY = 'in-array',
        FIELD = 'field', INTEGER = 'integer', IP = 'ip', JSON = 'json', MAX = 'max', MIMETYPES = 'mimetypes',
        MIMES = 'mimes', MIN = 'min', NULLABLE = 'nullable', NOT = 'not', NUMERIC = 'numeric', PRESENT = 'present',
        REGEX = 'regex', REQUIRED = 'required', REQUIRED_IF = 'required-if', SAME = 'same', SIZE = 'size',
        STRING = 'string', TIMEZONE = 'timezone', UNIQUE = 'unique', URL = 'url';

    /**
     * @param $value
     * @return bool
     */
    public function isRequired($value): bool
    {
        if (is_scalar($value)) {
            return strlen((string)$value) > 0;
        }
        return !empty(JSON::encode($value));
    }

    /**
     * @param $criteria
     * @param $value
     * @return array
     */
    public static function rule($criteria, $value): array
    {
        if (!is_array($criteria)) {
            $criteria = explode(',', $criteria);
        }
        $rules = [];
        foreach ($criteria as $key => $options) {
            if (is_numeric($key)) {
                $key = $options;
                $options = '';
            }
            $rules[$key] = $options;
        }
        return ['rules' => $rules, 'value' => $value];
    }

    /**
     * @param string $rule
     * @param $value
     * @param $options
     * @return bool
     */
    public function apply(string $rule, $value, $options): bool
    {
        $method = camelize("is-{$rule}");
        if (method_exists($this, $method)) {
            return $this->$method($value, $options);
        }
        return false;
    }

    /**
     * @param array $rules
     * @param $value
     * @return array
     */
    public function applyRules(array $rules, $value): array
    {
        $error = [];
        foreach ($rules as $rule => $options) {
            if (!$value && off($options, 'optional')) {
                continue;
            }
            $isValid = $this->apply($rule, $value, $options);
            if (!$isValid) {
                $error[] = ['rule' => $rule, 'value' => $value];
            }
            if ($isValid && off($options, 'enum')) {
                $enum = off($options, 'enum');
            }
            if (isset($enum) && !in_array($value, $enum)) {
                $error[] = ['rule' => 'enum', 'accepted' => $enum, 'value' => $value];
            }
        }
        return $error;
    }

    /**
     * @param array $validators
     * @return Record
     */
    public function parse(array $validators): Record
    {
        $errors = [];
        //stop($validators);
        foreach ($validators as $field => $settings) {
            $error = $this->applyRules(off($settings, 'rules'), off($settings, 'value'));
            if (count($error)) {
                $errors[$field] = $error;
            }
        }
        return Record::make($errors);
    }
}
