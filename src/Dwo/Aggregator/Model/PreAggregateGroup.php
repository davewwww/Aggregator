<?php

namespace Dwo\Aggregator\Model;

/**
 * Class PreAggregateGroup
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class PreAggregateGroup implements \Iterator
{
    use EntriesTrait;

    /**
     * @var int
     */
    private $count;

    /**
     * @var GroupKey
     */
    private $group;

    /**
     * @param GroupKey $group
     */
    public function __construct(GroupKey $group)
    {
        $this->group = $group;
    }

    /**
     * @return GroupKey
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param PreAggregate $aggregate
     */
    public function addEntry(PreAggregate $aggregate)
    {
        $this->entries[] = $aggregate;

        $this->count += $aggregate->getCount();
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }
}