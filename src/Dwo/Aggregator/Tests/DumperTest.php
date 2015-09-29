<?php

namespace Dwo\Aggregator\Tests;

use Dwo\Aggregator\Dumper;
use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\AggregateGroup;
use Dwo\Aggregator\Model\GroupKey;

class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $aggregateGroup = new AggregateGroup();
        $aggregateGroup->addAggregate($agg1 = new Aggregate(new GroupKey(['foo' => 'bar'])));
        $aggregateGroup->addAggregate($agg2 = new Aggregate(new GroupKey(['foo' => 'lorem'])));
        $agg1->setData(['a' => 1]);
        $agg2->setData(['b' => 1]);

        $dump = Dumper::toArray($aggregateGroup);

        self::assertInternalType('array', $dump);
        self::assertCount(2, $dump);

        self::assertEquals(
            array(
                'bar'   => array(
                    'a' => 1
                ),
                'lorem' => array(
                    'b' => 1
                )
            ),
            $dump
        );
    }

}