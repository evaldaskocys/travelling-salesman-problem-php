<?php

namespace TSP\Algorithms;

use TSP\WeightedEdge;

class CheapestLink implements AlgorithmInterface
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

        $e = 0;
        $tour = [];
        $degrees = array_fill(0, $order, 0);

        /* Sort the edges by weight */
        usort($edges, [$this, "compareWeightedEdges"]);

        /* Main algorithm */
        for ($t = 0; $t < $order; $t++) {
            $added = false;
            while (!$added && ($e < $size)) {
                if ($degrees[$edges[$e]->getFirst()] < 2 && $degrees[$edges[$e]->getSecond()] < 2) {
                    $tour[$t] = $edges[$e];

                    if ($t == $order - 1 /* It's the last edge */
                        || !$this->cyclic($tour, $t + 1, $order)) /* It doesn't close the circuit */
                    {
                        $added = true;
                        $degrees[$edges[$e]->getFirst()]++;
                        $degrees[$edges[$e]->getSecond()]++;
                    }
                }
                $e++;
            }

            if (!$added) { /* Edges were not correct */
                return null;
            }
        }

        return $tour;
    }

    /**
     * @param WeightedEdge $edge1
     * @param WeightedEdge $edge2
     * @return int
     */
    private function compareWeightedEdges(WeightedEdge $edge1, WeightedEdge $edge2)
    {
        return $edge1->getWeight() - $edge2->getWeight();
    }

    /**
     * @param WeightedEdge[] $edges
     * @param int $n
     * @param array $visited
     * @param int $order
     * @param int $vertex
     * @param int $predecessor
     *
     * @return bool
     */
    private function cyclicRecursive(array $edges, $n, array $visited, $order, $vertex, $predecessor)
    {
        $cycleFound = false;
        $visited[$vertex] = true;

        for ($i = 0; $i < $n; $i++) {
            if ($edges[$i]->getFirst() == $vertex || $edges[$i]->getSecond() == $vertex) {
                /* Adjacent */
                $neighbour = $edges[$i]->getFirst() == $vertex ? $edges[$i]->getSecond() : $edges[$i]->getFirst();

                if (!$visited[$neighbour]) {
                    /* Not yet visited */
                    $cycleFound = $this->cyclicRecursive($edges, $n, $visited, $order, $neighbour, $vertex);
                } elseif ($neighbour != $predecessor) {
                    /* Found a cycle */
                    $cycleFound = true;
                }
            }
            if ($cycleFound) {
                break;
            }
        }

        return $cycleFound;
    }

    private function cyclic(array $edges, $n, $order)
    {
        $visited = array_fill(0, $order, 0);

        if (!$order) {
            return false;
        }

        return $this->cyclicRecursive($edges, $n, $visited, $order, 0, 0);
    }
}

