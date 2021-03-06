<?php

namespace Dwo\Aggregator\Tests\Collector;

use Dwo\Aggregator\Collector\Collector;
use Dwo\Aggregator\Model\GroupSet;

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

        $i = 0;
        foreach ($collector as $e) {
            ++$i;
        }
        self::assertEquals(2, $i);
    }

    /**
     * @expectedException \Dwo\Aggregator\Exception\AggregatorException
     */
    public function testUnique()
    {
        $collector = new Collector(array('country'));
        $collector->setUnique(true);

        $collector->addEntry(['country' => 'DE']);
        $collector->addEntry(['country' => 'DE']);
    }

    public function testGroupSet()
    {
        $collector = new Collector(array('country'));
        $collector->addGroupSet('country', new GroupSet(['DE', 'AT'], 'ROW'));

        $collector->addEntry(['country' => 'DE']);
        $collector->addEntry(['country' => 'AT']);
        $collector->addEntry(['country' => 'CH']);
        $collector->addEntry(['country' => 'BR']);

        self::assertCount(3, $collector->getEntries());
        self::assertEquals(['DE', 'AT', 'ROW'], array_keys($collector->getEntries()));
    }

    public function testToArray()
    {
        $collector = new Collector(array('country'));
        $collector->addEntry(['country' => 'DE']);
        $collector->addEntry(['country' => 'AT']);
        $collector->addEntry(['country' => 'DE']);

        $dump = $collector->toArray();

        self::assertInternalType('array', $dump);
        self::assertCount(2, $dump);
    }
}