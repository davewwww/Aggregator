<?php

namespace Dwo\Aggregator\Collector;

use Dwo\Aggregator\Dumper\DeepDumper;
use Dwo\Aggregator\Exception\AggregatorException;
use Dwo\Aggregator\Model\EntriesTrait;
use Dwo\Aggregator\Model\GroupKey;
use Dwo\Aggregator\Model\GroupSet;
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
     * @var GroupSet[]|null
     */
    protected $groupSets;

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
     * @param string   $key
     * @param GroupSet $groupSets
     */
    public function addGroupSet($key, GroupSet $groupSets)
    {
        $this->groupSets[$key] = $groupSets;
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

        if (null !== $this->groupSets) {
            $data = $entry->getData();
            foreach ($this->groupSets as $key => $groupSet) {
                if (isset($data[$key])) {
                    $data[$key] = $groupSet->getValue($data[$key]);
                }
            }
            $entry->setData($data);
        }

        $group = GroupKey::create($entry->getData(), $this->getGroupKeys());
        $key = (string) $group;

        if (!isset($this->entries[$key])) {
            $this->entries[$key] = new PreAggregateGroup($group);
        } elseif ($this->unique) {
            throw new AggregatorException(sprintf('there is already a entry for this group: %s', $key));
        }

        $this->entries[$key]->addEntry($entry);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return DeepDumper::toArray($this);
    }
}