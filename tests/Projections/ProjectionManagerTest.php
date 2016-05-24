<?php

namespace tests\Projections;

use DeSmart\EventSourcing\EventStream;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionManager;
use stubs\PointsWereAdded;
use stubs\ProjectionStub;

class ProjectionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_registers_and_notifies_projection()
    {
        $projection = new ProjectionStub();
        $eventStream = new EventStream(...[new PointsWereAdded(100)]);

        $this->assertEquals(0, $projection->getPoints());
        
        $manager = new ProjectionManager();
        $manager->registerProjection($projection);
        $manager->notify($eventStream);
        
        $this->assertEquals(100, $projection->getPoints());
    }
}
