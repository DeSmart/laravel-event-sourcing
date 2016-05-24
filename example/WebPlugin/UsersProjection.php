<?php

namespace example\WebPlugin;

use DeSmart\EventSourcing\EventInterface;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionInterface;
use DeSmart\EventSourcing\WhenTrait;
use example\Domain\Events\UserWasCreated;
use example\Domain\Events\UserWasRemoved;
use Illuminate\Database\DatabaseManager;

class UsersProjection implements ProjectionInterface
{
    use WhenTrait;

    /**
     * @var array
     */
    protected $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }
    
    /**
     * @return void
     */
    public function clear()
    {
        $this->db->connection()
            ->table('users')
            ->delete();
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
     * @param UserWasCreated $event
     * @return void
     */
    protected function whenUserWasCreated(UserWasCreated $event)
    {
        $this->db->connection()
            ->table('users')
            ->insert([
                'id' => (string) $event->getAggregateRootId(),
                'name' => $event->getName(),
            ]);
    }

    /**
     * @param UserWasRemoved $event
     * @return void
     */
    protected function whenUserWasRemoved(UserWasRemoved $event)
    {
        $this->db->connection()
            ->table('users')
            ->delete((string) $event->getAggregateRootId());
    }
}