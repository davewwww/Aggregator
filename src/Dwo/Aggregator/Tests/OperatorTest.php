<?php

namespace Dwo\Aggregator\Tests;

use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\GroupKey;
use Dwo\Aggregator\Operator;

class OperatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAggregateWithOperator()
    {
        $origin = new Aggregate(new GroupKey([]));
        $origin->setData(['amount' => [2, 3, 3, 10]]);

        $aggregate = clone $origin;
        Operator::operation($aggregate, array('amount' => Operator::MEAN));
        self::assertEquals(['amount' => 4.5], $aggregate->getData());

        $aggregate = clone $origin;
        Operator::operation($aggregate, array('amount' => Operator::MEAN_HARMONIC));
        self::assertEquals(['amount' => 3.15], $aggregate->getData(), null, 0.1);

        $aggregate = clone $origin;
        Operator::operation($aggregate, array('amount' => Operator::MEDIAN));
        self::assertEquals(['amount' => 3], $aggregate->getData());
    }
}