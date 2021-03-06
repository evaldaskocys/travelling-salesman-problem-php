<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;

/**
 * Brute Force algorithm
 */
class BruteForce implements AlgorithmInterface
{
    /** @var array */
    protected $edges = [];

    /** @var int */
    protected $minWeight = 0;

    /** @var array */
    protected $bestTour = [];

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
     * @inheritdoc
     */
    public function getName()
    {
        return 'Brute Force Algorithm';
    }

    /**
     * @param array $items
     * @param array $perms
     */
    protected function permutations(array $items, array $perms = [])
    {
        if (empty($items)) { // if no items left to take
            array_unshift($perms, $this->edges[0]->getFirst());
            array_push($perms, $this->edges[0]->getFirst());
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
     */
    protected function calculateTotalWeight(array $perms)
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
                    break;
                }
            }
        }

        if ($weight < $this->minWeight || $this->minWeight == 0) {
            $this->minWeight = $weight;
            $this->bestTour = $tour;
        }
    }
}