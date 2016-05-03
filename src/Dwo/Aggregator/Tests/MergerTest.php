<?php

namespace Dwo\Aggregator\Tests;

use Dwo\Aggregator\Merger;
use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\GroupKey;
use Dwo\Aggregator\Model\PreAggregate;

class MergerTest extends \PHPUnit_Framework_TestCase
{
    public function testAggregates()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1]);
        $merge = clone $origin;

        Merger::merge($origin, $merge);

        self::assertEquals(['count' => 2], $origin->getData());
    }

    public function testAggregatesWithSaveKeys()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1, 'xid' => 1]);
        $merge = clone $origin;

        Merger::merge($origin, $merge, ['xid']);

        self::assertEquals(['count' => 2, 'xid' => 1], $origin->getData());
    }

    public function testAggregatesWithOriginIds()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->addOriginId(1);
        $merge = new Aggregate(new GroupKey([]));
        $merge->addOriginId(2);

        Merger::merge($origin, $merge, [], 'id');

        self::assertEquals([1, 2], $origin->getOriginIds());
    }

    public function testAggregatesSeveral()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1]);
        $merge1 = clone $origin;
        $merge2 = clone $origin;

        Merger::merge($origin, $merge1);
        Merger::merge($origin, $merge2);

        self::assertEquals(['count' => 3], $origin->getData());
    }

    public function testPreAggregates()
    {
        $origin = new PreAggregate(['count' => 1]);
        $merge = clone $origin;

        Merger::merge($origin, $merge);

        self::assertEquals(['count' => 2], $origin->getData());
    }

    public function testPreAggregatesSeveral()
    {
        $origin = new PreAggregate(['count' => 1]);
        $merge1 = clone $origin;
        $merge2 = clone $origin;

        Merger::merge($origin, $merge1);
        Merger::merge($origin, $merge2);

        self::assertEquals(['count' => 3], $origin->getData());
    }

    public function testPreAggregatesWithSaveKey()
    {
        $origin = new PreAggregate(['count' => 1, 'xid' => 1]);
        $merge = clone $origin;

        Merger::merge($origin, $merge, ['xid']);

        self::assertEquals(['count' => 2, 'xid' => 1], $origin->getData());
    }

    public function testPreAggregatesWithIdKey()
    {
        $origin = new PreAggregate(['count' => 1, 'id' => 1]);
        $merge = clone $origin;

        Merger::merge($origin, $merge, [], 'id');

        self::assertEquals(['count' => 2, 'id' => 1], $origin->getData());
    }

    public function testArregateWithPreAggregates()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1]);
        $merge = new PreAggregate(['count' => 1]);

        Merger::merge($origin, $merge);

        self::assertEquals(['count' => 2], $origin->getData());
    }

    public function testArregateWithPreAggregatesSeveral()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1]);
        $merge1 = new PreAggregate(['count' => 1]);
        $merge2 = new PreAggregate(['count' => 1]);
        $merge3 = new PreAggregate(['count' => 1]);

        Merger::merge($origin, $merge1);
        Merger::merge($origin, $merge2);
        Merger::merge($origin, $merge3);

        self::assertEquals(['count' => 4], $origin->getData());
    }

    public function testArregateWithPreAggregatesWithId()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['count' => 1]);
        $merge = new PreAggregate(['count' => 2], 2);

        Merger::merge($origin, $merge);

        self::assertEquals(['count' => 3], $origin->getData());
        self::assertEquals([2], $origin->getOriginIds());
    }

    public function testArrays()
    {
        $origin = ['count' => 1, 'sum' => '2', 'counts' => ['a' => 2], 'foo' => 'bar'];
        $merge = $origin;

        Merger::merge($origin, $merge);

        self::assertEquals(['count' => 2, 'sum' => 4, 'counts' => ['a' => 4], 'foo' => 'bar'], $origin);
    }


    public function testArraysWithSaveKey()
    {
        $origin = ['count' => 1, 'xid' => '2'];
        $merge = $origin;

        Merger::merge($origin, $merge, ['xid']);

        self::assertEquals(['count' => 2, 'xid' => '2'], $origin);
    }

    public function testArraysSeveral()
    {
        $origin = ['count' => 1];
        $merge1 = $origin;
        $merge2 = $origin;

        Merger::merge($origin, $merge1);
        Merger::merge($origin, $merge2);

        self::assertEquals(['count' => 3], $origin);
    }

    public function testArraysSeveralAndNull()
    {
        $origin = ['count' => 1];
        $merges = [];
        $merges[] = ['count' => 1];
        $merges[] = ['count' => null];
        $merges[] = ['count' => 1];
        $merges[] = ['count' => 1];

        foreach($merges as $merge) {
            Merger::merge($origin, $merge);
        }

        self::assertEquals(['count' => 4], $origin);
    }

    public function testArraysSeveralAndNullAtStart()
    {
        $origin = ['count' => null];
        $merge1 = ['count' => 1];
        $merge2 = ['count' => 1];

        Merger::merge($origin, $merge1);
        Merger::merge($origin, $merge2);

        self::assertEquals(['count' => 2], $origin);
    }

    /**
     * @expectedException \Dwo\Aggregator\Exception\AggregatorException
     */
    public function testError()
    {
        $origin = new Aggregate(new GroupKey([]));
        $merge = ['count' => 1];

        Merger::merge($origin, $merge);
    }
}