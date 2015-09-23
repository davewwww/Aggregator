<?php

namespace Dwo\Aggregator\Model;

use Dwo\SimpleAccessor\SimpleAccessor;

/**
 * Class GroupKey
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class GroupKey
{
    /**
     * @var array
     */
    protected $keys;

    /**
     * @param array $keys
     */
    public function __construct(array $keys)
    {
        ksort($keys);
        $this->keys = $keys;
    }

    /**
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * @param array $data
     * @param array $groupKeys
     *
     * @return GroupKey
     */
    public static function create(array $data, array $groupKeys)
    {
        $keys = [];
        foreach ($groupKeys as $key) {
            $value = SimpleAccessor::getValueFromPath($data, $key);
            $keys[$key] = $value = !is_scalar($value) ? json_encode($value) : $value;
        }

        return new GroupKey($keys);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode('_', $this->getKeys());
    }
}