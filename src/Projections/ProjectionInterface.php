<?php

namespace DeSmart\EventSourcing\Laravel\Projections;

use DeSmart\EventSourcing\EventInterface;

interface ProjectionInterface
{
    /**
     * @return void
     */
    public function clear();

    /**
     * @param EventInterface $event
     * @return void
     */
    public function notify(EventInterface $event);
}
