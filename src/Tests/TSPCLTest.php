<?php

namespace TSP\Tests;

use PHPUnit\Framework\TestCase;
use TSP\Algorithms\CheapestLink;
use TSP\TSP;

class TSPCLTest extends TestCase
{
    /** @var TSP */
    private $tsp;

    public function setUp()
    {
        $algorithm = new CheapestLink();
        $this->tsp = new TSP($algorithm);
    }

    public function testCL1()
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

        $this->assertEquals('(0, 4, 16) (1, 5, 17) (2, 3, 18) (0, 2, 19) (1, 4, 27) (3, 5, 32) ',
            $this->tsp->getEdges());

        $this->assertEquals(129, $this->tsp->getTotalWeight());
    }

    public function testCL2()
    {
        $this->tsp->weightedEdgeConnect(0, 1, 10)
            ->weightedEdgeConnect(0, 2, 5)
            ->weightedEdgeConnect(0, 3, 4)
            ->weightedEdgeConnect(0, 4, 11)
            ->weightedEdgeConnect(1, 2, 7)
            ->weightedEdgeConnect(1, 3, 13)
            ->weightedEdgeConnect(1, 4, 2)
            ->weightedEdgeConnect(2, 3, 3)
            ->weightedEdgeConnect(2, 4, 9)
            ->weightedEdgeConnect(3, 4, 8);

        $this->tsp->calculateTour();

        $this->assertEquals('(1, 4, 2) (2, 3, 3) (0, 3, 4) (1, 2, 7) (0, 4, 11) ',
            $this->tsp->getEdges());

        $this->assertEquals(27, $this->tsp->getTotalWeight());
    }
}