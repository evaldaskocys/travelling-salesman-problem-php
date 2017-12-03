<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;

interface AlgorithmInterface
{
    /**
     * @param WeightedEdge[] $edges
     * @param int $size
     * @param int $order
     *
     * @return WeightedEdge[]|null
     */
    public function getTour(array $edges, $size, $order);
}