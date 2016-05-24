<?php

namespace example\Domain\Events;

use DeSmart\EventSourcing\EventInterface;
use example\Domain\UserId;

final class UserWasCreated implements EventInterface, \JsonSerializable
{
    /**
     * @var UserId
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \DateTime
     */
    protected $recordedOn;

    /**
     * @param UserId $id
     * @param string $name
     */
    public function __construct(UserId $id, $name)
    {
        $this->id = $id;
        $this->name = $name;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
            'name' => $this->name,
            'recordedOn' => $this->recordedOn->format(\DateTime::ATOM),
        ];
    }

    /**
     * @param array $payload
     * @return UserWasCreated
     */
    public static function createFromPayload(array $payload)
    {
        $event = new UserWasCreated(new UserId($payload['id']), $payload['name']);
        $event->recordedOn = date_create($payload['recordedOn']);
        
        return $event;
    }
}