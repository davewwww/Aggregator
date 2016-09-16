<?php

namespace Dwo\Aggregator\Tests;

use Dwo\Aggregator\Aggregator;
use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Collector\IdCollector;
use Dwo\Aggregator\Operator;

class AggregatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAggregate()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry(['country' => 'DE', 'sum' => 1, 'counts' => ['a' => 2]]);
        $collector->addEntry(['country' => 'DE', 'sum' => 2, 'counts' => ['a' => 1]]);
        $collector->addEntry(['country' => 'AT', 'sum' => 1, 'counts' => ['a' => 1]]);

        $aggGroup = Aggregator::aggregate($collector);
        self::assertCount(2, $aggGroup->getEntries());

        $aggDE = $aggGroup->getEntryByKey('DE');
        self::assertEquals(['country' => 'DE', 'sum' => 3, 'counts' => ['a' => 3]], $aggDE->getData());
        self::assertEquals(['country' => 'DE'], $aggDE->getGroup()->getKeys());
        self::assertEquals(2, $aggDE->getCount());

        $aggDE = $aggGroup->getEntryByKey('AT');
        self::assertEquals(['country' => 'AT', 'sum' => 1, 'counts' => ['a' => 1]], $aggDE->getData());
        self::assertEquals(1, $aggDE->getCount());
    }

    public function testAggregateWithInc()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry(['country' => 'DE', 'sum' => 2], 2);
        $collector->addEntry(['country' => 'DE', 'sum' => 1], 1);
        $collector->addEntry(['country' => 'AT', 'sum' => 2], 2);

        $aggGroup = Aggregator::aggregate($collector);

        $aggDE = $aggGroup->getEntryByKey('DE');
        self::assertEquals(3, $aggDE->getCount());

        $aggDE = $aggGroup->getEntryByKey('AT');
        self::assertEquals(2, $aggDE->getCount());
    }

    public function testAggregateWithSaveKeys()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry(['xid' => 1, 'country' => 'DE', 'sum' => 1]);
        $collector->addEntry(['xid' => 1, 'country' => 'DE', 'sum' => 2]);
        $collector->addEntry(['xid' => 2, 'country' => 'AT', 'sum' => 2]);
        $collector->addEntry(['xid' => 2, 'country' => 'AT', 'sum' => 3]);

        $aggGroup = Aggregator::aggregate($collector, array('xid'));

        $aggDE = $aggGroup->getEntryByKey('DE');
        self::assertEquals(['xid' => 1, 'country' => 'DE', 'sum' => 3], $aggDE->getData());
        $aggDE = $aggGroup->getEntryByKey('AT');
        self::assertEquals(['xid' => 2, 'country' => 'AT', 'sum' => 5], $aggDE->getData());
    }

    public function testAggregateWithOperator()
    {
        $collector = new Collector([]);
        $collector->addEntry(['amount' => 1]);
        $collector->addEntry(['amount' => 2]);
        $collector->addEntry(['amount' => 3]);
        $collector->addEntry(['amount' => 3]);
        $collector->addEntry(['amount' => 3]);
        $collector->addEntry(['amount' => 7]);
        $collector->addEntry(['amount' => 100]);

        $agg = Aggregator::aggregate($collector, array('amount' => Operator::MEAN));
        self::assertEquals(['amount' => 17.0], current($agg->toArray()));

        $agg = Aggregator::aggregate($collector, array('amount' => Operator::MEAN_HARMONIC));
        self::assertEquals(['amount' => 2.6], current($agg->toArray()), null, 0.1);

        $agg = Aggregator::aggregate($collector, array('amount' => Operator::MEDIAN));
        self::assertEquals(['amount' => 3], current($agg->toArray()));
    }

    public function testAggregateWithOriginIds()
    {
        $collector = new IdCollector(array('country'), 'id');

        $collector->addEntry(['id' => 1, 'country' => 'DE', 'sum' => 1]);
        $collector->addEntry(['id' => 2, 'country' => 'DE', 'sum' => 2]);
        $collector->addEntry(['id' => 3, 'country' => 'AT', 'sum' => 2]);
        $collector->addEntry(['id' => 4, 'country' => 'AT', 'sum' => 3]);

        $aggGroup = Aggregator::aggregate($collector);

        $aggDE = $aggGroup->getEntryByKey('DE');
        self::assertEquals([1, 2], $aggDE->getOriginIds());
        self::assertEquals(['country' => 'DE', 'sum' => 3], $aggDE->getData());

        $aggAT = $aggGroup->getEntryByKey('AT');
        self::assertEquals([3, 4], $aggAT->getOriginIds());
        self::assertEquals(['country' => 'AT', 'sum' => 5], $aggAT->getData());
    }
}