<?php

namespace TSP\Tests;

use PHPUnit\Framework\TestCase;
use TSP\Algorithms\BruteForce;
use TSP\TSP;

class TSPBFTest extends TestCase
{
    /** @var TSP */
    private $tsp;

    public function setUp()
    {
        $algorithm = new BruteForce();
        $this->tsp = new TSP($algorithm);
    }

    public function testBF1()
    {
        $this->tsp->weightedEdgeConnect(0, 1, 10)
            ->weightedEdgeConnect(0, 2, 5)
            ->weightedEdgeConnect(0, 3, 4)
            ->weightedEdgeConnect(1, 2, 7)
            ->weightedEdgeConnect(1, 3, 13)
            ->weightedEdgeConnect(2, 3, 3);


        $this->tsp->calculateTour();

        $this->assertEquals('(0, 1, 10) (1, 2, 7) (2, 3, 3) (0, 3, 4) ',
            $this->tsp->getEdgesString());

        $this->assertEquals(24, $this->tsp->getTotalWeight());
    }

    public function testBF2()
    {
        $this->tsp->weightedEdgeConnect(0, 1, 25)
            ->weightedEdgeConnect(0, 2, 19)
            ->weightedEdgeConnect(0, 3, 19)
            ->weightedEdgeConnect(0, 4, 16)
            ->weightedEdgeConnect(0, 5, 28)
            ->weightedEdgeConnect(1, 2, 24)
            ->weightedEdgeConnect(1, 3, 30)
            ->weightedEdgeConnect(1, 4, 27)
            ->weightedEdgeConnect(1, 5, 17)
            ->weightedEdgeConnect(2, 3, 18)
            ->weightedEdgeConnect(2, 4, 20)
            ->weightedEdgeConnect(2, 5, 23)
            ->weightedEdgeConnect(3, 4, 19)
            ->weightedEdgeConnect(3, 5, 32)
            ->weightedEdgeConnect(4, 5, 41);

        $this->tsp->calculateTour();

        $this->assertEquals('(0, 1, 25) (1, 5, 17) (2, 5, 23) (2, 3, 18) (3, 4, 19) (0, 4, 16) ',
            $this->tsp->getEdgesString());

        $this->assertEquals(118, $this->tsp->getTotalWeight());
    }
}