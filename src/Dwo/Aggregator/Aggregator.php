<?php

namespace Dwo\Aggregator;

use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Collector\IdCollector;
use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\AggregateGroup;
use Dwo\Aggregator\Model\PreAggregateGroup;

/**
 * Class Aggregator
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Aggregator
{
    /**
     * @param Collector|PreAggregateGroup[] $collector
     * @param array                         $saveKeys
     *
     * @return AggregateGroup
     */
    public static function aggregate(Collector $collector, array $saveKeys = [])
    {
        $idKey = $collector instanceof IdCollector ? $collector->getIdKey() : null;

        $group = new AggregateGroup();
        foreach ($collector as $groupKey => $preAggregateGroup) {
            $group->addAggregate($aggregate = new Aggregate($preAggregateGroup->getGroup()));
            foreach ($preAggregateGroup as $preAggregate) {
                Merger::merge($aggregate, $preAggregate, $saveKeys, $idKey);
            }
        }

        return $group;
    }
}