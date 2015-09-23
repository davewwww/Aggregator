<?php

namespace Dwo\Aggregator\Tests\Collector;

use Dwo\Aggregator\Collector\IdCollector;

class IdCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $collector = new IdCollector(array('country'), 'id');
        self::assertEquals('id', $collector->getIdKey());
    }

    public function testGetById()
    {
        $collector = new IdCollector(array('country'), 'id');
        $collector->addEntry($data = ['id' => 1, 'country' => 'DE', 'sum' => 1]);

        self::assertNotNull($collector->getById(1));
        self::assertNull($collector->getById(2));
        self::assertEquals($data, $collector->getById(1)->getData());
    }

    public function testExtendsGroupedCollector()
    {
        $collector = new IdCollector(array('country'), 'id');
        self::assertInstanceOf('Dwo\Aggregator\Collector\Collector', $collector);
    }
}