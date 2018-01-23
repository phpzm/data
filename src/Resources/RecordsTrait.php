<?php

namespace Simples\Data\Resources;

/**
 * Trait CollectionRecords
 * @package Simples\Data\Resources
 */
trait RecordsTrait
{
    /**
     * @var array
     */
    protected $records = [];

    /**
     * @return array
     */
    public function all()
    {
        return $this->getRecords();
    }

    /**
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * @return array
     */
    public function records()
    {
        return $this->getRecords();
    }

    /**
     * @return mixed
     */
    protected function expose()
    {
        return $this->getRecords();
    }
}