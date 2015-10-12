<?php

namespace Dwo\Aggregator\Tests\Dumper;

use Dwo\Aggregator\Aggregator;
use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Dumper\DeepDumper;

class DeepDumperTest extends \PHPUnit_Framework_TestCase
{
    public function testToArrayCollector()
    {
        $collector = new Collector(array('country', 'gender', 'age'));
        $collector->addEntry($data = ['id' => 1, 'country' => 'DE', 'gender' => 'male', 'age' => 18]);
        $collector->addEntry(['id' => 2, 'country' => 'DE', 'gender' => 'female', 'age' => 21]);
        $collector->addEntry(['id' => 3, 'country' => 'FR', 'gender' => 'male', 'age' => 18]);

        $dump = DeepDumper::toArray($collector);
        self::assertArrayHasKey('DE', $dump);
        self::assertArrayHasKey('FR', $dump);

        self::assertArrayHasKey('male', $dump['DE']);
        self::assertArrayHasKey('female', $dump['DE']);

        self::assertArrayHasKey(18, $dump['DE']['male']);
        self::assertEquals($data, current($dump['DE']['male'][18]));
    }

    public function testToArrayAggregate()
    {
        $collector = new Collector(array('country', 'gender', 'age'));
        $collector->addEntry($data = ['id' => 1, 'country' => 'DE', 'gender' => 'male', 'age' => 18]);
        $collector->addEntry(['id' => 2, 'country' => 'DE', 'gender' => 'female', 'age' => 21]);
        $collector->addEntry(['id' => 3, 'country' => 'FR', 'gender' => 'male', 'age' => 18]);

        $aggregate = Aggregator::aggregate($collector);
        $dump = DeepDumper::toArray($aggregate);

        self::assertArrayHasKey('DE', $dump);
        self::assertArrayHasKey('FR', $dump);

        self::assertArrayHasKey('male', $dump['DE']);
        self::assertArrayHasKey('female', $dump['DE']);

        self::assertArrayHasKey(18, $dump['DE']['male']);
        self::assertEquals($data, $dump['DE']['male'][18]);
    }
}