<?php

namespace Dwo\Aggregator\Dumper;

/**
 * Class FlatDumper
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class FlatDumper
{
    /**
     * @param \Iterator $group
     *
     * @return array
     */
    public static function toArray(\Iterator $group)
    {
        $dump = [];

        foreach ($group as $id => $aggregate) {
            $dump[$id] = $aggregate->getData();
        }

        return $dump;
    }
}