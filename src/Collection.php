<?php

namespace Simples\Data;

use Simples\Error\SimplesRunTimeError;

/**
 * Class Collection
 * @property Collection map
 * @property Collection filter
 * @property Collection each
 * @package Simples\Core\Domain
 */
final class Collection extends CollectionAbstract
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * @var array
     */
    protected $higher = [];

    /**
     * @var array
     */
    protected $mutations = [];

    /**
     * Collection constructor.
     * @param array $records
     * @param mixed $model (null)
     */
    public function __construct(array $records = [], $model = null)
    {
        $this->records = $records;
        $this->model = $model;
    }

    /**
     * @param array $records
     * @param mixed $model (null)
     * @return Collection
     */
    public static function make(array $records = [], $model = null): Collection
    {
        return new static($records, $model);
    }

    /**
     * @param $model
     * @return Collection
     */
    public function model($model): Collection
    {
        $this->model = $model;
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this;
    }

    /**
     * is utilized for reading data from inaccessible members.
     *
     * @param $name string
     * @return Collection
     * @throws SimplesRunTimeError
     * @link http://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __get($name): Collection
    {
        if (!method_exists($this, $name)) {
            throw new SimplesRunTimeError("Method '{$name}' not found");
        }
        $this->higher[] = $name;
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this;
    }

    /** @noinspection SpellCheckingInspection */
    /**
     * Ex.:
     *   $result = Collection::create([new Example('apple'), new Example('orange')])
     *      ->map->each->getFruit()->getRecords();
     *   var_dump($result);
     *   ["elppa", "egnaro"]
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws SimplesRunTimeError
     */
    public function __call($name, $arguments)
    {
        if ($this->higher) {
            $records = $this->records;
            foreach ($this->higher as $higher) {
                $records = $this->{$higher}(function ($value) use ($name, $arguments) {
                    return call_user_func_array([$value, $name], $arguments);
                });
            }
            $this->higher = [];
            return $records;
        }
        $model = $this->model;
        if ($model) {
            return $this->map(function ($value) use ($model, $name, $arguments) {
                return call_user_func_array([$model, $name], [$value]);
            });
        }
        throw new SimplesRunTimeError("Not found '{$name}'");
    }

    /**
     * @param callable $callback
     * @return Collection
     */
    public function each(callable $callback): Collection
    {
        foreach ($this->records as $key => $record) {
            $this->records[$key] = $callback($record);
        }
        return $this;
    }

    /**
     * @param callable $callback
     * @return array
     */
    public function map(callable $callback)
    {
        return array_map($callback, $this->records);
    }

    /**
     * @param callable $callback
     * @return array
     */
    public function filter(callable $callback)
    {
        return array_filter($this->records, $callback);
    }

    /**
     * @return int
     */
    public function size()
    {
        return count($this->records);
    }

    /**
     * @return Record
     */
    public function current()
    {
        $current = current($this->records);
        if (!$current) {
            $current = [];
        }
        return Record::make($current, true, $this->mutations);
    }

    /**
     * @param string $field
     * @param callable $callable
     * @return Collection
     */
    public function on(string $field, callable $callable)
    {
        $this->mutations[$field] = $callable;
        return $this;
    }

    /**
     * @param string $field
     * @return Collection
     */
    public function off(string $field)
    {
        unset($this->mutations[$field]);
        return $this;
    }
}
