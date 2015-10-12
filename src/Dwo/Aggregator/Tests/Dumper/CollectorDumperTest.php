<?php

namespace Dwo\Aggregator\Tests\Dumper;

use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Dumper\CollectorDumper;

class CollectorDumperTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $collector = new Collector(array('country', 'gender', 'age'));
        $collector->addEntry($data = ['id' => 1, 'country' => 'DE', 'gender' => 'male', 'age' => 18]);
        $collector->addEntry(['id' => 2, 'country' => 'DE', 'gender' => 'female', 'age' => 21]);
        $collector->addEntry(['id' => 3, 'country' => 'FR', 'gender' => 'male', 'age' => 18]);

        $dump = CollectorDumper::toArray($collector);
        self::assertArrayHasKey('DE', $dump);
        self::assertArrayHasKey('FR', $dump);

        self::assertArrayHasKey('male', $dump['DE']);
        self::assertArrayHasKey('female', $dump['DE']);

        self::assertArrayHasKey(18, $dump['DE']['male']);
        self::assertEquals($data, current($dump['DE']['male'][18]));
    }
}