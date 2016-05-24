<?php

namespace tests\Projections;

use DeSmart\EventSourcing\EventStream;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionManager;
use stubs\PointsWereAdded;
use stubs\ProjectionStub;

class ProjectionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ProjectionManager
     */
    protected $projectionManager;

    /**
     * @var ProjectionStub
     */
    protected $projection;

    public function setUp()
    {
        $this->projection = new ProjectionStub();
        $this->projectionManager = new ProjectionManager();
    }

    /**
     * @test
     */
    public function it_registers_and_notifies_projection()
    {
        $eventStream = new EventStream(new PointsWereAdded(100));

        $this->assertEquals(0, $this->projection->getPoints());

        $this->projectionManager->registerProjection($this->projection);
        $this->projectionManager->notify($eventStream);
        $this->assertEquals(100, $this->projection->getPoints());
    }

    /**
     * @test
     */
    public function it_clears_projection()
    {
        $eventStream = new EventStream(new PointsWereAdded(100));

        $this->assertEquals(0, $this->projection->getPoints());

        $this->projectionManager->registerProjection($this->projection);
        $this->projectionManager->notify($eventStream);
        $this->assertEquals(100, $this->projection->getPoints());

        $this->projectionManager->clear();
        $this->assertEquals(0, $this->projection->getPoints());
    }
}
