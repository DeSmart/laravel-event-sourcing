<?php

namespace tests\EventStore;

use DeSmart\EventSourcing\EventStoreInterface;
use DeSmart\EventSourcing\EventStream;
use DeSmart\EventSourcing\Laravel\EventStore\DbEventStore;
use DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Prophecy\Argument;
use stubs\BarId;
use stubs\PointsWereAdded;

class DbEventStoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbEventStore
     */
    protected $eventStore;

    /**
     * @var Connection
     */
    protected $db;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var Builder
     */
    protected $queryBuilder;
    
    public function setUp()
    {
        $this->queryBuilder = $this->prophesize(Builder::class);

        $this->db = $this->prophesize(Connection::class);
        $this->serializer = $this->prophesize(SerializerInterface::class);

        $this->eventStore = new DbEventStore($this->db->reveal(), $this->serializer->reveal());
    }

    /**
     * @test
     */
    public function it_is_event_store()
    {
        $this->assertInstanceOf(EventStoreInterface::class, $this->eventStore);
    }

    /**
     * @test
     */
    public function it_loads_all_events()
    {
        $this->db->table('events')->willReturn($this->queryBuilder);
        $this->queryBuilder->chunk(1000, Argument::any())->willReturn(true);

        $this->eventStore->loadAll();
    }

    /**
     * @test
     */
    public function it_load_events_for_aggregate()
    {
        $aggregateRootId = new BarId('BarId');

        $this->db->table('events')->willReturn($this->queryBuilder);
        $this->queryBuilder->where('aggregate_root_id', 'BarId')->willReturn($this->queryBuilder);
        $this->queryBuilder->chunk(1000, Argument::any())->willReturn(true);

        $this->eventStore->load($aggregateRootId);
    }

    /**
     * @test
     */
    public function it_appends_events()
    {
        $event = new PointsWereAdded(100);
        $stream = new EventStream($event);

        $eventData = [
            'aggregate_root_id' => 'BarId',
            'type' => PointsWereAdded::class,
            'payload' => ['amount' => '100']
        ];

        $this->db->table('events')->willReturn($this->queryBuilder);
        $this->serializer->serialize($event)->willReturn(['amount' => '100']);
        $this->queryBuilder->insert([$eventData])->willReturn(true);

        $this->eventStore->append($stream);
    }
}
