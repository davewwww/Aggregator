<?php

namespace Dwo\Aggregator\Dumper;

use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\AggregateGroup;
use Dwo\Aggregator\Model\PreAggregate;

/**
 * Class AggregateGroupDumper
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class AggregateGroupDumper
{
    /**
     * @param \Iterator $group
     *
     * @return array
     */
    public static function toArray(\Iterator $group)
    {
        $dump = [];

        /** @var PreAggregate $aggregate */
        foreach ($group as $id => $aggregate) {
            $dump[$id] = $aggregate->getData();
        }

        return $dump;
    }
}