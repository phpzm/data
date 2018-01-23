<?php

namespace Simples\Data\Resources;

use Simples\Data\Record;

/**
 * Trait CollectionIterator
 * @package Simples\Data
 */
trait IteratorTrait
{
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
     *
     */
    public function rewind()
    {
        reset($this->records);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        $var = key($this->records);
        return $var;
    }

    /**
     * @return mixed
     */
    public function next()
    {
        $var = next($this->records);
        return $var;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        $key = key($this->records);
        $var = ($key !== null && $key !== false);
        return $var;
    }

}
