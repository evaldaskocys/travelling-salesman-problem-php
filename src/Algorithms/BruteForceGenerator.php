<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;
use Generator;

/**
 * Brute Force algorithm
 */
class BruteForceGenerator extends BruteForce implements AlgorithmInterface
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

        $this->edges = $edges;

        $items = [];
        for ($i = 1; $i < $order; $i++) {
            $items[] = $i;
        }

        foreach ($this->permutations($items) as $permutation) {
            array_unshift($permutation, $this->edges[0]->getFirst());
            array_push($permutation, $this->edges[0]->getFirst());
            $this->calculateTotalWeight($permutation);
        }

        return $this->bestTour;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Brute Force Algorithm with Generators';
    }

    /**
     * @param array $items
     * @param array $perms
     * @return Generator
     */
    protected function permutations(array $items, array $perms = [])
    {
        if (empty($items)) { // if no items left to take
            yield $perms;
        }  else {
            for ($i = count($items) - 1; $i >= 0; --$i) { // for all remaining items
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1); // take 1 element from $newitems
                array_unshift($newperms, $foo); // put that element in front of $newperms
                yield from $this->permutations($newitems, $newperms);
            }
        }
    }
}