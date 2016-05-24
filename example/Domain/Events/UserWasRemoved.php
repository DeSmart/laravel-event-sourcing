<?php

namespace example\Domain\Events;

use DeSmart\EventSourcing\EventInterface;
use example\Domain\UserId;

final class UserWasRemoved implements EventInterface, \JsonSerializable
{
    /**
     * @var UserId
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $recordedOn;

    /**
     * @param UserId $id
     */
    public function __construct(UserId $id)
    {
        $this->id = $id;
        $this->recordedOn = date_create();
    }

    /**
     * @return UserId
     */
    public function getAggregateRootId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getRecordedOn()
    {
        return $this->recordedOn;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'recordedOn' => $this->recordedOn->format(\DateTime::ATOM),
        ];
    }
    
    /**
     * @param array $payload
     * @return UserWasCreated
     */
    public static function createFromPayload(array $payload)
    {
        $event = new UserWasRemoved(new UserId($payload['id']));
        $event->recordedOn = date_create($payload['recordedOn']);
        
        return $event;
    }
}
