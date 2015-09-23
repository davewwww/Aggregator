<?php

namespace Dwo\Aggregator;

use Dwo\Aggregator\Exception\AggregatorException;
use Dwo\Aggregator\Model\Aggregate;
use Dwo\Aggregator\Model\PreAggregate;

/**
 * Class Merger
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Merger
{
    /**
     * merges Aggregate+Aggregate | Aggregate+PreAggregate | PreAggregate+PreAggregate | array()+array()
     *
     * @param Aggregate|PreAggregate|array $origin
     * @param Aggregate|PreAggregate|array $merge
     * @param array                        $saveKeys
     * @param string|null                  $idKey
     */
    public static function merge(&$origin, $merge, array $saveKeys = [], $idKey = null)
    {
        $checkMergeType = function ($a) {
            if ($a instanceof Aggregate) {
                return 16;
            } elseif ($a instanceof PreAggregate) {
                return 4;
            } else {
                if (is_array($a)) {
                    return 1;
                }
            }

            return null;
        };

        $typeOne = $checkMergeType($origin);
        $typeTwo = $checkMergeType($merge);
        $mergeType = $typeOne + $typeTwo;

        if (32 === $mergeType) {
            self::mergeAgg($origin, $merge, $saveKeys, $idKey);
        } elseif (16 === $typeOne && 4 === $typeTwo) {
            self::mergePreToAgg($origin, $merge, $saveKeys, $idKey);
        } elseif (8 <= $mergeType) {
            self::mergePre($origin, $merge, $saveKeys, $idKey);
        } elseif (2 === $mergeType) {
            self::mergeArrays($origin, $merge, $saveKeys);
        } else {
            throw new AggregatorException('cant be merged');
        }
    }

    /**
     * @param Aggregate   $origin
     * @param Aggregate   $merge
     * @param array       $saveKeys
     * @param string|null $idKey
     */
    private static function mergeAgg(Aggregate $origin, Aggregate $merge, array $saveKeys = [], $idKey = null)
    {
        self::mergePre($origin, $merge, $saveKeys, $idKey);

        foreach ($merge->getOriginIds() as $id) {
            $origin->addOriginId($id);
        }
    }

    /**
     * @param Aggregate    $origin
     * @param PreAggregate $merge
     * @param array        $saveKeys
     * @param string|null  $idKey
     */
    private static function mergePreToAgg(Aggregate $origin, PreAggregate $merge, array $saveKeys = [], $idKey = null)
    {
        self::mergePre($origin, $merge, $saveKeys, $idKey);

        if (null !== $id = $merge->getId()) {
            $origin->addOriginId($id);
        }
    }

    /**
     * @param PreAggregate $origin
     * @param PreAggregate $merge
     * @param array        $saveKeys
     * @param string|null  $idKey
     */
    private static function mergePre(PreAggregate $origin, PreAggregate $merge, array $saveKeys = [], $idKey = null)
    {
        $originData = $origin->getData();
        $data = $merge->getData();
        if (null !== $idKey) {
            unset($data[$idKey]);
        }

        self::mergeArrays($originData, $data, $saveKeys);

        $origin->setData($originData);
        $origin->incrementCount($merge->getCount());
    }

    /**
     * @param array $dataOrigin
     * @param array $data
     * @param array $saveKeys
     */
    private static function mergeArrays(array &$dataOrigin, array $data, array $saveKeys = [])
    {
        foreach ($data as $key => $value) {
            if (!isset($dataOrigin[$key])) {
                $dataOrigin[$key] = null;
            }

            $mergeable = !in_array($key, $saveKeys);

            switch (true) {
                case is_numeric($value) && $mergeable:
                    $dataOrigin[$key] += $value;
                    break;

                case is_array($value) && $mergeable:
                    if (null === $dataOrigin[$key]) {
                        $dataOrigin[$key] = [];
                    }
                    self::mergeArrays($dataOrigin[$key], $value);
                    break;

                default:
                    $dataOrigin[$key] = $value;
                    break;
            }
        }
    }
}