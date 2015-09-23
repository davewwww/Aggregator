<?php

namespace Dwo\Aggregator\Tests\Model;

use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\GroupKey;

class AggregateTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $aggregate = new Aggregate($group = new GroupKey(['foo'=>'bar']));
        self::assertEquals($group, $aggregate->getGroup());
        self::assertCount(0, $aggregate->getData());
        self::assertEquals(0, $aggregate->getCount());
        self::assertCount(0, $aggregate->getOriginIds());
    }

    public function testSetter()
    {
        $aggregate = new Aggregate($group = new GroupKey(['foo'=>'bar']));
        $aggregate->setData(['foo']);
        $aggregate->addOriginId(1);
        $aggregate->incrementCount(2);

        self::assertEquals(['foo'], $aggregate->getData());
        self::assertEquals($group, $aggregate->getGroup());
        self::assertEquals(2, $aggregate->getCount());
        self::assertEquals([1], $aggregate->getOriginIds());
    }
}