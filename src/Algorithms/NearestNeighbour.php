<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;

class NearestNeighbour implements AlgorithmInterface
{
    /**
     * @param WeightedEdge[] $edges
     * @param int $size
     * @param int $order
     *
     * @return WeightedEdge[]|null
     */
    public function getTour(array $edges, $size, $order)
    {
        if (!$order) {
            return null;
        }

        $v = 0;
        $tour = [];

        for ($t = 0; $t < $order; $t++) {
            $key = $this->getNearestNeighbourEdgeKey($edges, $size, $tour, $t, $v, $order);
            $tour[$t] = $edges[$key];
            $v = $edges[$key]->getFirst() == $v ? $edges[$key]->getSecond() : $edges[$key]->getFirst();
        }

        return $tour;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Nearest Neighbour Algorithm';
    }

    /**
     * Find the edge to v's nearest neighbour not in the tour already
     *
     * @param WeightedEdge[] $edges
     * @param int $size
     * @param WeightedEdge[] $tour
     * @param int $t
     * @param int $v
     * @param int $order
     *
     * @return int|null
     */
    private function getNearestNeighbourEdgeKey(array $edges, $size, array $tour, $t, $v, $order)
    {
        $minDistance = 0;
        $nearestNeighbourKey = null;

        for ($i = 0; $i < $size; $i++) {
            if (($edges[$i]->getFirst() == $v || $edges[$i]->getSecond() == $v) &&
                ($minDistance == 0 || $edges[$i]->getWeight() < $minDistance) &&
                (
                    !$this->tourContains($tour, $t, $edges[$i]) ||
                    ($t == $order - 1 && $edges[$i]->getFirst() == $edges[0]->getFirst()) /* It's the last edge */
                )
            ) {
                $minDistance = $edges[$i]->getWeight();
                $nearestNeighbourKey = $i;
            }
    }

        return $nearestNeighbourKey;
    }

    /**
     * Check if the tour already contains an edge
     *
     * @param WeightedEdge[] $tour
     * @param int $t
     * @param WeightedEdge $edge
     *
     * @return boolean
     */
    private function tourContains(array $tour, $t, WeightedEdge $edge)
    {
        $tourContainsFirstVertex = false;
        $tourContainsSecondVertex = false;

        for ($i = 0; $i < $t; $i++) {

            if ($this->tourEdgeContainsVertex($edge->getFirst(), $tour[$i])) {
                $tourContainsFirstVertex = true;
            }
            if ($this->tourEdgeContainsVertex($edge->getSecond(), $tour[$i])) {
                $tourContainsSecondVertex = true;
            }
        }

        return $tourContainsFirstVertex && $tourContainsSecondVertex;
    }

    /**
     * @param int $vertex
     * @param WeightedEdge $tourEdge
     * @return bool
     */
    private function tourEdgeContainsVertex($vertex, WeightedEdge $tourEdge)
    {
        return in_array($vertex, [$tourEdge->getFirst(), $tourEdge->getSecond()]);
    }
}