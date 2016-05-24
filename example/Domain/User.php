<?php

namespace example\Domain;

use DeSmart\EventSourcing\AggregateRootInterface;
use DeSmart\EventSourcing\AggregateRootTrait;

class User implements AggregateRootInterface
{
    use AggregateRootTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @param UserId $id
     * @param string $name
     * @return static
     */
    public static function create(UserId $id, $name)
    {
        $user = new static;
        $user->recordThat(new UserWasCreated($id, $name));

        return $user;
    }

    /**
     * @return $this
     */
    public function remove()
    {
        $this->recordThat(new UserWasRemoved($this->id));

        return $this;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param UserWasCreated $event
     * @return void
     */
    protected function whenUserWasCreated(UserWasCreated $event)
    {
        $this->id = $event->getAggregateRootId();
        $this->name = $event->getName();
        $this->active = true;
    }

    /**
     * @param UserWasRemoved $event
     * @return void
     */
    protected function whenUserWasRemoved(UserWasRemoved $event)
    {
        $this->active = false;
    }
}