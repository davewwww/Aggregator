<?php

namespace Dwo\Aggregator\Model;

/**
 * Trait Entries
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
trait EntriesTrait
{
    /**
     * @var array
     */
    protected $entries = [];

    /**
     * @return array
     */
    public function getEntries()
    {
        return (array) $this->entries;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getEntryByKey($key)
    {
        return isset($this->entries[$key]) ? $this->entries[$key] : null;
    }

    /**
     * @param string $key
     */
    public function removeEntryByKey($key)
    {
        if (isset($this->entries[$key])) {
            unset($this->entries[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        return reset($this->entries);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->entries);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->entries);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->entries);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return key($this->entries) !== null;
    }
}