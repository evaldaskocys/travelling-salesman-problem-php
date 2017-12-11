<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;

/**
 * Brute Force algorithm
 */
class BruteForce implements AlgorithmInterface
{
    /** @var array */
    private $edges = [];

    /** @var int */
    private $minWeight = 0;

    /** @var array */
    private $bestTour = [];

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

        $this->edges = $edges;

        $items = [];
        for ($i = 1; $i < $order; $i++) {
            $items[] = $i;
        }
        $this->permutations($items);

        return $this->bestTour;
    }

    /**
     * @param array $items
     * @param array $perms
     */
    private function permutations(array $items, array $perms = [])
    {
        if (empty($items)) { // if no items left to take
            array_unshift($perms, 0);
            array_push($perms, 0);
            $this->calculateTotalWeight($perms);
        }  else {
            for ($i = count($items) - 1; $i >= 0; --$i) { // for all remaining items
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1); // take 1 element from $newitems
                array_unshift($newperms, $foo); // put that element in front of $newperms
                $this->permutations($newitems, $newperms);
            }
        }
    }

    /**
     * @param array $perms
     * @return int
     */
    private function calculateTotalWeight(array $perms)
    {
        $weight = 0;
        $tour = [];

        for($i = 0; $i < count($perms) - 1; $i++) {
            /** @var WeightedEdge $weightedEdge */
            foreach($this->edges as $weightedEdge) {
                if (($weightedEdge->getFirst() == $perms[$i] && $weightedEdge->getSecond() == $perms[$i+1]) ||
                    ($weightedEdge->getFirst() == $perms[$i+1] && $weightedEdge->getSecond() == $perms[$i])) {
                    $tour[] = $weightedEdge;
                    $weight += $weightedEdge->getWeight();
                }
            }
        }

        if ($weight < $this->minWeight || $this->minWeight == 0) {
            $this->minWeight = $weight;
            $this->bestTour = $tour;
        }

        return $weight;
    }
}