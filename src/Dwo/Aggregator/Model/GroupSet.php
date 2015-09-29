<?php

namespace Dwo\Aggregator\Model;

/**
 * Class GroupSet
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class GroupSet
{
    /**
     * @var array
     */
    protected $in;

    /**
     * @var string
     */
    protected $out;

    /**
     * @param array  $in
     * @param string $out
     */
    public function __construct(array $in, $out)
    {
        $this->in = $in;
        $this->out = $out;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function getValue($value)
    {
        if (!in_array($value, $this->in)) {
            $value = $this->out;
        }

        return $value;
    }
}