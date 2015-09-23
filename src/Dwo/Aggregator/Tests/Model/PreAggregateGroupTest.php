<?php

namespace Dwo\Aggregator\Tests\Model;

use Dwo\Aggregator\Model\GroupKey;
use Dwo\Aggregator\Model\PreAggregate;
use Dwo\Aggregator\Model\PreAggregateGroup;

class PreAggregateGroupTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCount()
    {
        $aggregateGroup = new PreAggregateGroup(new GroupKey([]));
        $aggregateGroup->addEntry(new PreAggregate([]));

        self::assertEquals(1, $aggregateGroup->getCount());
    }

    public function testSetCount()
    {
        $aggregateGroup = new PreAggregateGroup(new GroupKey([]));
        $aggregateGroup->addEntry(new PreAggregate([]));
        $aggregateGroup->setCount(2);

        self::assertEquals(2, $aggregateGroup->getCount());
    }

    public function testRemoveEntry()
    {
        $aggregateGroup = new PreAggregateGroup(new GroupKey([]));
        $aggregateGroup->addEntry(new PreAggregate([]));

        self::assertNotNull($aggregateGroup->getEntryByKey(0));

        $aggregateGroup->removeEntryByKey(0);

        self::assertNull($aggregateGroup->getEntryByKey(0));
    }
}