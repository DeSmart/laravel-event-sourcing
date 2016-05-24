<?php

namespace DeSmart\EventSourcing\Laravel\Projections;

use DeSmart\EventSourcing\EventInterface;
use DeSmart\EventSourcing\EventStreamInterface;

class ProjectionManager
{
    /**
     * @var ProjectionInterface[]
     */
    protected $projections = [];

    /**
     * @param ProjectionInterface $projection
     * @return $this
     */
    public function registerProjection(ProjectionInterface $projection)
    {
        $this->projections[] = $projection;
        
        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        foreach ($this->projections as $projection) {
            $projection->clear();
        }
        
        return $this;
    }

    /**
     * @param EventStreamInterface $eventStream
     * @return $this
     */
    public function notify(EventStreamInterface $eventStream)
    {
        foreach ($eventStream as $event) {
            $this->notifyProjections($event);
        }

        return $this;
    }

    /**
     * @param EventInterface $event
     * @return $this
     */
    public function notifyProjections(EventInterface $event)
    {
        foreach ($this->projections as $projection) {
            $projection->notify($event);
        }

        return $this;
    }
}
