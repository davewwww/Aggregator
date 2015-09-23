<?php

namespace Dwo\Aggregator\Model;

/**
 * Class PreAggregate
 *
 * @author Dave Www <davewwwo@gmail.com>
 */
class PreAggregate
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var string|null
     */
    protected $id;

    /**
     * @var int
     */
    protected $count;

    /**
     * :TODO: refactor construct
     *
     * @param array       $data
     * @param string|null $id
     * @param int         $count
     */
    public function __construct($data, $id = null, $count = 1)
    {
        $this->data = $data;
        $this->id = $id;
        $this->count = $count;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return (array) $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int) $this->count;
    }

    /**
     * @param int $count
     */
    public function incrementCount($count = 1)
    {
        $this->count += $count;
    }
}