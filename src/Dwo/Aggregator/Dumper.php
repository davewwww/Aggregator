<?php

namespace Dwo\Aggregator;

use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\AggregateGroup;

/**
 * Class Dumper
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Dumper
{
    /**
     * @param AggregateGroup $aggregateGroup
     *
     * @return array
     */
    public static function toArray(AggregateGroup $aggregateGroup)
    {
        $dump = [];

        /** @var Aggregate $aggregate */
        foreach ($aggregateGroup as $id => $aggregate) {
            $dump[$id] = $aggregate->getData();
        }

        return $dump;
    }
}