<?php

namespace Simples\Data\Validators;

use Simples\Kernel\Container;
use Simples\Model\ModelAbstract;
use Simples\Persistence\Filter;

/**
 * Class DateValidator
 * @package Simples\Data\Validators
 */
trait DatabaseValidator
{
    /**
     * @param $value
     * @return mixed
     */
    public function isField($value)
    {
        return $value;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function isNullable($value)
    {
        return $value;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isReject($value): bool
    {
        return empty($value);
    }

    /**
     * @param $value
     * @param $options
     * @return mixed
     */
    public function isUnique($value, $options)
    {
        $class = off($options, 'class');
        $field = off($options, 'field');
        if (class_exists($class)) {
            $instance = Container::instance()->make($class);
            /** @var ModelAbstract $instance */
            $filter = [$field => $value];
            if (off($options, 'primaryKey.value')) {
                $pk = off($options, 'primaryKey.value');
                $filter[off($options, 'primaryKey.name')] = Filter::apply(Filter::RULE_NOT, $pk);
            }
            return $instance->count($filter) === 0;
        }
        return false;
    }
}
