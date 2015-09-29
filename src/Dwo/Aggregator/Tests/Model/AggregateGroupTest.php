<?php

namespace Dwo\Aggregator\Tests\Model;

use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\AggregateGroup;
use Dwo\Aggregator\Model\GroupKey;

class AggregateGroupTest extends \PHPUnit_Framework_TestCase
{
    public function testIteration()
    {
        $aggregateGroup = new AggregateGroup();
        $aggregateGroup->addAggregate(new Aggregate(new GroupKey(['foo' => 'bar'])));
        $aggregateGroup->addAggregate(new Aggregate(new GroupKey(['foo' => 'lorem'])));

        $i=0;
        foreach($aggregateGroup as $aggregate) {
            ++$i;
        }
        self::assertEquals(2, $i);
    }

    public function testToArray()
    {
        $aggregateGroup = new AggregateGroup();
        $aggregateGroup->addAggregate(new Aggregate(new GroupKey(['foo' => 'bar'])));
        $aggregateGroup->addAggregate(new Aggregate(new GroupKey(['foo' => 'lorem'])));

        $dump = $aggregateGroup->toArray();

        self::assertInternalType('array', $dump);
        self::assertCount(2, $dump);
    }
}