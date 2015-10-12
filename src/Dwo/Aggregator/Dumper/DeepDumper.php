<?php

namespace Dwo\Aggregator\Dumper;

use Dwo\Aggregator\Model\Aggregate;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class DeepDumper
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class DeepDumper
{
    /**
     * @param \Iterator $group
     *
     * @return array
     */
    public static function toArray(\Iterator $group)
    {
        $dump = array();
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($group as $entry) {
            $values = array_values($entry->getGroup()->getKeys());
            $keys = sprintf('[%s]', implode('][', $values));

            if($entry instanceof \Iterator) {
                $entry = FlatDumper::toArray($entry);
            }
            else if($entry instanceof Aggregate) {
                $entry = $entry->getData();
            }

            $accessor->setValue($dump, $keys, $entry);
        }

        return $dump;
    }
}