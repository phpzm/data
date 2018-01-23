<?php

namespace Simples\Data;

use function array_reduce;
use ArrayAccess;
use Iterator;
use Simples\Data\Resources\AccessTrait;
use Simples\Data\Resources\GroupTrait;
use Simples\Data\Resources\IteratorTrait;
use Simples\Data\Resources\ManipulationTrait;
use Simples\Data\Resources\ModelTrait;
use Simples\Data\Resources\MutationTrait;
use Simples\Data\Resources\RecordsTrait;
use Simples\Unit\Origin;

/**
 * Class Collection
 * @property Collection map
 * @property Collection filter
 * @property Collection each
 * @package Simples\Data
 */
final class Collection extends Origin implements ArrayAccess, Iterator
{
    /**
     * @trait
     */
    use AccessTrait, IteratorTrait, GroupTrait, RecordsTrait, ModelTrait, MutationTrait, ManipulationTrait;

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
}
