<?php

namespace TSP;

use TSP\Algorithms\AlgorithmInterface;

class TSP
{
    /** @var AlgorithmInterface */
    private $algorithm;

    /** @var array */
    private $vertices = [];

    /** @var WeightedEdge[] */
    private $edges = [];

    /** @var WeightedEdge[] */
    private $tour = [];

    /**
     * TSP constructor.
     * @param AlgorithmInterface $algorithm
     */
    public function __construct(AlgorithmInterface $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * Connect two edges
     *
     * @param int $first
     * @param int $second
     * @param int $weight
     *
     * @return TSP
     */
    public function weightedEdgeConnect($first, $second, $weight)
    {
        $edge = new WeightedEdge($first, $second, $weight);
        $this->edges[] = $edge;

        $this->insertToVerticesIfNotPresent($first);
        $this->insertToVerticesIfNotPresent($second);

        return $this;
    }

    public function calculateTour()
    {
        $size = count($this->edges);
        $order = count($this->vertices);

        $this->tour = $this->algorithm->getTour($this->edges, $size, $order);
    }

    /**
     * Returns all edges in traveling order in string format
     *
     * @return string
     */
    public function getEdges()
    {
        $string = '';

        foreach($this->tour as $edge) {
            $string .= sprintf("(%s, %s, %s) ", $edge->getFirst(), $edge->getSecond(), $edge->getWeight());
        }

        return $string;
    }

    /**
     * Returns all edges total weight
     *
     * @return string
     */
    public function getTotalWeight()
    {
        $weight = 0;

        foreach($this->tour as $edge) {
            $weight += $edge->getWeight();
        }

        return $weight;
    }

    /**
     * @param int $vertex
     */
    private function insertToVerticesIfNotPresent($vertex)
    {
        if (!in_array($vertex, $this->vertices)) {
            $this->vertices[] = $vertex;
        }
    }
}