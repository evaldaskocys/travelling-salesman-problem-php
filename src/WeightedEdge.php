<?php

namespace TSP;

class WeightedEdge
{
    /** @var int */
    private $first;
    /** @var int */
    private $second;
    /** @var int */
    private $weight;

    /**
     * WeightedEdge constructor.
     * @param int $first
     * @param int $second
     * @param int $weight
     */
    public function __construct($first, $second, $weight)
    {
        $this->first = $first;
        $this->second = $second;
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * @return int
     */
    public function getSecond()
    {
        return $this->second;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }
}