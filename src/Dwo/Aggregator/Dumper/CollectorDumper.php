<?php

namespace Dwo\Aggregator\Dumper;

use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Model\PreAggregateGroup;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class CollectorDumper
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class CollectorDumper
{
    /**
     * @param Collector $collector
     *
     * @return array
     */
    public static function toArray(Collector $collector)
    {
        $dump = array();
        $accessor = PropertyAccess::createPropertyAccessor();

        /** @var PreAggregateGroup $entry */
        foreach ($collector->getEntries() as $entry) {
            $values = array_values($entry->getGroup()->getKeys());
            $keys = sprintf('[%s]', implode('][', $values));
            $accessor->setValue($dump, $keys, AggregateGroupDumper::toArray($entry));
        }

        return $dump;
    }
}