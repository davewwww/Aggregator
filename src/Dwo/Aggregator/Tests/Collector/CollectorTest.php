<?php

namespace Dwo\Aggregator\Tests\Collector;

use Dwo\Aggregator\Collector\Collector;

class CollectorTest extends \PHPUnit_Framework_TestCase
{
    public function testEmpty()
    {
        $collector = new Collector(array('country'));
        self::assertEquals(array('country'), $collector->getGroupKeys());
    }

    public function testGetGroupByKey()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry($data = ['id' => 1, 'country' => 'DE', 'sum' => 1]);

        self::assertCount(1, $entries = $collector->getEntryByKey('DE')->getEntries());
        self::assertInstanceOf('Dwo\Aggregator\Model\PreAggregate', $entries[0]);
        self::assertEquals($data, $entries[0]->getData());
    }

    public function testGetAllGroups()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry(['id' => 1, 'country' => 'DE', 'sum' => 1]);
        $collector->addEntry(['id' => 2, 'country' => 'DE', 'sum' => 1]);
        $collector->addEntry(['id' => 3, 'country' => 'AT', 'sum' => 1]);
        $collector->addEntry(['id' => 4, 'country' => 'AT', 'sum' => 1]);

        self::assertCount(2, $entries = $collector->getEntries());
    }

    public function testIteration()
    {
        $collector = new Collector(array('country'));

        $collector->addEntry(['country' => 'DE']);
        $collector->addEntry(['country' => 'AT']);

        $i=0;
        foreach($collector as $e) {
            ++$i;
        }
        self::assertEquals(2, $i);
    }
}