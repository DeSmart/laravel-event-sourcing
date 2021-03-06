<?php

namespace stubs;

use DeSmart\EventSourcing\EventInterface;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionInterface;
use DeSmart\EventSourcing\WhenTrait;

class ProjectionStub implements ProjectionInterface
{
    use WhenTrait;

    /**
     * @var int
     */
    protected $points = 0;

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @return void
     */
    public function clear()
    {
        $this->points = 0;
    }

    /**
     * @param EventInterface $event
     * @return void
     */
    public function notify(EventInterface $event)
    {
        $this->when($event);
    }

    /**
     * @param PointsWereAdded $event
     * @return void
     */
    protected function whenPointsWereAdded(PointsWereAdded $event)
    {
        $this->points += $event->getAmount();
    }
}