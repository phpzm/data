<?php

namespace Simples\Data\Resources;

use Simples\Data\Collection;
use Simples\Error\SimplesRunTimeError;

/**
 * Trait CollectionModel
 * @package Simples\Data\Resources
 */
trait ModelTrait
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
     *   $result = Collection::make([new Example('apple'), new Example('orange')])
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
}
