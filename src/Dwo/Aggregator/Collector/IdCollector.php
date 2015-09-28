<?php

namespace Dwo\Aggregator\Collector;

use Dwo\Aggregator\Model\PreAggregate;

/**
 * Class IdCollector
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class IdCollector extends Collector
{
    /**
     * @var string
     */
    protected $idKey;

    /**
     * @var PreAggregate[]
     */
    protected $idEntries;

    /**
     * @param array  $groupKeys
     * @param string $idKey
     */
    public function __construct(array $groupKeys, $idKey)
    {
        parent::__construct($groupKeys);
        $this->idKey = $idKey;
        $this->idEntries = [];
    }

    /**
     * @return string
     */
    public function getIdKey()
    {
        return $this->idKey;
    }

    /**
     * :TODO: maybe countKey instead of $inc
     *
     * @param mixed $entry
     * @param int   $inc
     */
    public function addEntry($entry, $inc = 1)
    {
        $id = $entry[$this->getIdKey()];

        $this->idEntries[$id] = $entry = new PreAggregate($entry, $id, $inc);

        parent::addEntry($entry, $inc);
    }

    /**
     * :TODO: rename
     *
     * @return PreAggregate[]
     */
    public function getIds()
    {
        return $this->idEntries;
    }

    /**
     * @param string $id
     *
     * @return PreAggregate
     */
    public function getById($id)
    {
        return isset($this->idEntries[$id]) ? $this->idEntries[$id] : null;
    }
}