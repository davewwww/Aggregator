<?php

namespace Dwo\Aggregator\Tests\Model;

use Dwo\Aggregator\Model\GroupKey;

class GroupKeyTest extends \PHPUnit_Framework_TestCase
{
    public function testOneKey()
    {
        $group = new GroupKey(['foo' => 'bar']);
        self::assertEquals(['foo' => 'bar'], $group->getKeys());
        self::assertEquals('bar', (string) $group);
    }

    public function testSeveralKeys()
    {
        $group = new GroupKey(['lorem' => 'ipsum', 'foo' => 'bar']);
        self::assertEquals(['foo' => 'bar', 'lorem' => 'ipsum'], $group->getKeys());
        self::assertEquals('ipsum_bar', (string) $group);
    }

    public function testCreate()
    {
        $data = ['lorem' => 'ipsum', 'foo' => 'bar'];
        $group = GroupKey::create($data, ['foo']);
        self::assertEquals(['foo' => 'bar'], $group->getKeys());
        self::assertEquals('bar', (string) $group);
    }
}