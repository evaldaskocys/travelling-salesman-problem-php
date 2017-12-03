<?php

use PHPUnit\Framework\TestCase;

class TSPCLTest extends TestCase
{
    public function testCL()
    {
        $algorithm = new \TSP\Algorithms\CheapestLink();
        $tsp = new \TSP\TSP($algorithm);

        $tsp->weightedEdgeConnect(0, 1, 25)
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

        $tsp->calculateTour();

        $this->assertEquals('(0, 4, 16) (1, 5, 17) (2, 3, 18) (0, 2, 19) (1, 4, 27) (3, 5, 32) ',
            $tsp->getEdges());

        $this->assertEquals(129, $tsp->getTotalWeight());
    }

    public function testCL2()
    {
        $algorithm = new \TSP\Algorithms\CheapestLink();
        $tsp = new \TSP\TSP($algorithm);

        $tsp->weightedEdgeConnect(0, 1, 10)
            ->weightedEdgeConnect(0, 2, 5)
            ->weightedEdgeConnect(0, 3, 4)
            ->weightedEdgeConnect(0, 4, 11)
            ->weightedEdgeConnect(1, 2, 7)
            ->weightedEdgeConnect(1, 3, 13)
            ->weightedEdgeConnect(1, 4, 2)
            ->weightedEdgeConnect(2, 3, 3)
            ->weightedEdgeConnect(2, 4, 9)
            ->weightedEdgeConnect(3, 4, 8);

        $tsp->calculateTour();

        $this->assertEquals('(1, 4, 2) (2, 3, 3) (0, 3, 4) (1, 2, 7) (0, 4, 11) ',
            $tsp->getEdges());

        $this->assertEquals(27, $tsp->getTotalWeight());

    }
}