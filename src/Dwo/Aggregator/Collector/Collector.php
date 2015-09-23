<?php

namespace Dwo\Aggregator\Collector;

use Dwo\Aggregator\Exception\AggregatorException;
use Dwo\Aggregator\Model\EntriesTrait;
use Dwo\Aggregator\Model\GroupKey;
use Dwo\Aggregator\Model\PreAggregate;
use Dwo\Aggregator\Model\PreAggregateGroup;

/**
 * Class Collector
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Collector implements \Iterator
{
    use EntriesTrait;

    /**
     * @var array
     */
    protected $groupKeys;

    /**
     * @var bool
     */
    protected $unique;

    /**
     * @param array $groupKeys
     */
    public function __construct(array $groupKeys)
    {
        $this->groupKeys = $groupKeys;
        $this->unique = false;
    }

    /**
     * @return array
     */
    public function getGroupKeys()
    {
        return $this->groupKeys;
    }

    /**
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }


    /**
     * :TODO: maybe count key instead of $inc
     *
     * @param PreAggregate|mixed $entry
     * @param int                $inc
     */
    public function addEntry($entry, $inc = 1)
    {
        if (!$entry instanceof PreAggregate) {
            $entry = new PreAggregate($entry, null, $inc);
        }

        $group = GroupKey::create($entry->getData(), $this->getGroupKeys());
        $key = (string) $group;

        if (!isset($this->entries[$key])) {
            $this->entries[$key] = new PreAggregateGroup($group);
        }
        elseif($this->unique) {
            throw new AggregatorException(sprintf('there is already a entry for this group: %s', $key));
        }

        $this->entries[$key]->addEntry($entry);
    }
}