<?php

namespace Simples\Data\Resources;

use Simples\Data\Collection;

/**
 * Trait CollectionMutation
 * @package Simples\Data\Resources
 */
trait MutationTrait
{
    /**
     * @var array
     */
    protected $mutations = [];

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