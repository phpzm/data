<?php

namespace Simples\Data\Resources;

use Simples\Data\Collection;

/**
 * Trait CollectionManipulation
 * @package Simples\Data\Resources
 */
trait ManipulationTrait
{
    /**
     * @param callable $callback
     * @return Collection
     */
    public function each(callable $callback): Collection
    {
        foreach ($this->records as $key => $record) {
            $this->records[$key] = $callback($record);
        }
        /** @var Collection $this */
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
     * @return int
     */
    public function length()
    {
        return $this->size();
    }

    /**
     * @param callable $callable
     * @param mixed $initial
     * @return mixed
     */
    public function reduce(callable $callable, $initial)
    {
        return array_reduce($this->records, $callable, $initial);
    }
}