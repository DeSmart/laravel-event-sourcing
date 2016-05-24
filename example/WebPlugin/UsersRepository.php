<?php

namespace example\WebPlugin;

use DeSmart\EventSourcing\EventStoreInterface;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionManager;
use example\Domain\User;
use example\Domain\UserId;
use example\Domain\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @var EventStoreInterface
     */
    protected $eventStore;

    /**
     * @var ProjectionManager
     */
    protected $projectionManager;

    /**
     * @param EventStoreInterface $eventStore
     * @param ProjectionManager $projectionManager
     */
    public function __construct(EventStoreInterface $eventStore, ProjectionManager $projectionManager)
    {
        $this->eventStore = $eventStore;
        $this->projectionManager = $projectionManager;
    }

    /**
     * @param UserId $id
     * @return User
     */
    public function get(UserId $id)
    {
        $eventStream = $this->eventStore->load($id);

        return User::reconstituteFrom($eventStream);    
    }

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user)
    {
        $recordedEvents = $user->getRecordedEvents();

        $this->eventStore->append($recordedEvents);
        $this->projectionManager->notify($recordedEvents);
    }
}