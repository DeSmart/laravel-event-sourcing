<?php

namespace DeSmart\EventSourcing\Laravel\EventStore;

use DeSmart\EventSourcing\AggregateRootIdInterface;
use DeSmart\EventSourcing\EventInterface;
use DeSmart\EventSourcing\EventStoreInterface;
use DeSmart\EventSourcing\EventStream;
use DeSmart\EventSourcing\EventStreamInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;

class DbEventStore implements EventStoreInterface
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param Connection $db
     * @param SerializerInterface $serializer
     */
    public function __construct(Connection $db, SerializerInterface $serializer)
    {
        $this->db = $db;
        $this->serializer = $serializer;
    }

    /**
     * @param AggregateRootIdInterface $aggregateRootId
     * @return EventStreamInterface
     */
    public function load(AggregateRootIdInterface $aggregateRootId)
    {
        $queryBuilder = $this->db
            ->table('events')
            ->where('aggregate_root_id', (string) $aggregateRootId);

        return $this->getEventStream($queryBuilder);
    }

    /**
     * @return EventStreamInterface
     */
    public function loadAll()
    {
        $queryBuilder = $this->db
            ->table('events');

        return $this->getEventStream($queryBuilder);
    }

    /**
     * @param Builder $builder
     * @return EventStreamInterface
     */
    protected function getEventStream(Builder $builder)
    {
        $events = [];

        $builder->chunk(1000, function ($dbEvents) use (&$events) {
            array_push($events, ...array_map(function ($dbEvent) {
                $dbEvent = (array) $dbEvent;

                /** @var EventInterface $eventClass */
                $eventClass = $dbEvent['type'];

                $payload = $this->serializer->deserialize($dbEvent['payload']);
                $payload['id'] = $dbEvent['aggregate_root_id'];

                return $eventClass::createFromPayload($payload);
            }, $dbEvents));
        });

        return new EventStream(...$events);
    }

    /**
     * @param EventStreamInterface $eventStream
     * @return void
     * @throws SerializationException
     */
    public function append(EventStreamInterface $eventStream)
    {
        $events = collect(iterator_to_array($eventStream))->map(function ($event) {
            /** @var EventInterface $event */

            return [
                'aggregate_root_id' => (string) $event->getAggregateRootId(),
                'type' => get_class($event),
                'payload' => $this->serializer->serialize($event),
            ];
        });

        $this->db
            ->table('events')
            ->insert($events->toArray());
    }
}