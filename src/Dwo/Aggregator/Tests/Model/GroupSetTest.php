<?php

namespace Dwo\Aggregator\Tests\Model;

use Dwo\Aggregator\Model\GroupSet;

class GroupSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testGetValue(array$set, $out, $value, $result)
    {
        $group = new GroupSet($set, $out);
        self::assertEquals($result, $group->getValue($value));
    }

    public function provider()
    {
        return array(
            array(['foo'], null, 'foo', 'foo'),
            array(['foo'], null, 'bar', null),
            array(['foo'], 'bar', 'foobar', 'bar'),
            array(['foo', 'bar'], null, 'foo', 'foo'),
            array(['foo', 'bar'], null, 'bar', 'bar'),
            array(['foo', 'bar'], null, 'foobar', null),
            array(['foo', 'bar'], 'lorem', 'foobar', 'lorem'),
        );
    }
}