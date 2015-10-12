<?php

namespace Dwo\Aggregator\Model;

use Dwo\Aggregator\Dumper\FlatDumper;

/**
 * Class AggregateGroup
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class AggregateGroup implements \Iterator
{
    use EntriesTrait;

    /**
     * @param Aggregate $aggregate
     */
    public function addAggregate(Aggregate $aggregate)
    {
        $this->entries[(string) $aggregate->getGroup()] = $aggregate;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return FlatDumper::toArray($this);
    }
}