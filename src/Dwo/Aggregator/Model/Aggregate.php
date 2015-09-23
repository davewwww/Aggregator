<?php

namespace Dwo\Aggregator\Model;

/**
 * Class Aggregate
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Aggregate extends PreAggregate
{
    /**
     * @var GroupKey
     */
    protected $group;

    /**
     * @var array
     */
    protected $originIds;

    /**
     * @param GroupKey $group
     */
    public function __construct(GroupKey $group)
    {
        $this->group = $group;
        $this->originIds = [];

        parent::__construct([], (string) $group, 0);
    }

    /**
     * @return GroupKey
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return array
     */
    public function getOriginIds()
    {
        return (array) $this->originIds;
    }

    /**
     * @param int $originId
     */
    public function addOriginId($originId)
    {
        $this->originIds[] = $originId;
    }
}