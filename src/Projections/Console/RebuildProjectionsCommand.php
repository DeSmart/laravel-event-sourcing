<?php

namespace DeSmart\EventSourcing\Laravel\Projections\Console;

use DeSmart\EventSourcing\EventStoreInterface;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionManager;
use Illuminate\Console\Command;

class RebuildProjectionsCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'projections:rebuild';

    /**
     * @var string
     */
    protected $description = 'Rebuild all projections.';

    /**
     * @param ProjectionManager $projectionManager
     * @param EventStoreInterface $eventStore
     * @return void
     */
    public function handle(ProjectionManager $projectionManager, EventStoreInterface $eventStore)
    {
        $eventStream = $eventStore->loadAll();
        
        $projectionManager->clear();
        $projectionManager->notify($eventStream);
    }
}