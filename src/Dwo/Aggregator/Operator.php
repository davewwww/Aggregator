<?php

namespace Dwo\Aggregator;

use Dwo\Aggregator\Model\Aggregate;
use Malenki\Math\Stats\Stats;

/**
 * Class Operator
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class Operator
{
    const MEAN = 'mean';
    const MEAN_HARMONIC = 'mean_harmonic';
    const MEDIAN = 'median';

    /**
     * @param Aggregate $aggregate
     * @param array     $saveKeys
     */
    public static function operation(Aggregate $aggregate, array $saveKeys = [])
    {
        $data = $aggregate->getData();

        $operations = [];
        foreach (array_keys($data) as $key) {
            if (isset($saveKeys[$key])) {
                $operations[$key] = $saveKeys[$key];
            }
        }

        foreach ($operations as $key => $operation) {
            $stats = new Stats($data[$key]);
            switch ($operation) {
                default:
                    if (!method_exists($stats, $operation)) {
                        $operation = self::MEAN;
                    }
                    $data[$key] = $stats->$operation();
                case self::MEAN:
                    $data[$key] = $stats->mean();
                    break;
                case self::MEAN_HARMONIC:
                    $data[$key] = $stats->harmonicMean();
                    break;
                case self::MEDIAN:
                    $data[$key] = $stats->median();
                    break;
            }
        }

        $aggregate->setData($data);
    }

}