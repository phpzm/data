<?php

namespace Simples\Data\Resources;

use Simples\Data\Collection;

/**
 * Trait Group
 * @package Simples\Data\Resources
 */
trait GroupRecords
{
    /**
     * @var array
     */
    private $grouping = [];

    /**
     * @param array $properties
     * @return Collection
     */
    public function groupBy(array $properties): Collection
    {
        $previous = current($properties);
        $this->grouping = $this->groupReduces($this->records, $previous);
        $next = next($properties);
        foreach ($this->grouping[$previous] as $id => $value) {
            $this->grouping[$previous][$id] = $this->groupReduces((array)$value, $next);
        }
        return Collection::make($this->grouping);
    }

    /**
     * @param array $array
     * @param string $property
     * @return array
     */
    protected function groupReduces(array $array, string $property): array
    {
        return array_reduce($array, function ($carry, $item) use ($property, $array) {
            /** @noinspection PhpVariableVariableInspection */
            $id = $item->$property;
            if (!isset($carry[$property])) {
                $carry[$property] = [];
            }
            if (!isset($carry[$property][$id])) {
                $carry[$property][$id] = [];
            }
            $carry[$property][$id][] = $item;
            return $carry;
        }, []);
    }
}
