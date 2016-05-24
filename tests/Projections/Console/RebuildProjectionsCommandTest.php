<?php

namespace tests\Projections\Console;

use DeSmart\EventSourcing\EventStoreInterface;
use DeSmart\EventSourcing\EventStreamInterface;
use DeSmart\EventSourcing\Laravel\Projections\Console\RebuildProjectionsCommand;
use DeSmart\EventSourcing\Laravel\Projections\ProjectionManager;
use Illuminate\Console\Command;

class RebuildProjectionsCommandTest extends \PHPUnit_Framework_TestCase
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
     * @var RebuildProjectionsCommand
     */
    protected $command;

    public function setUp()
    {
        $this->eventStore = $this->prophesize(EventStoreInterface::class);
        $this->projectionManager = $this->prophesize(ProjectionManager::class);

        $this->command = new RebuildProjectionsCommand();
    }

    /**
     * @test
     */
    public function it_is_command()
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }

    /**
     * @test
     */
    public function it_handles_rebuilding_projections()
    {
        $stream = $this->prophesize(EventStreamInterface::class);
        
        $this->eventStore->loadAll()->willReturn($stream);
        $this->projectionManager->clear()->shouldBeCalled();
        $this->projectionManager->notify($stream)->shouldBeCalled();
        
        $this->command->handle($this->projectionManager->reveal(), $this->eventStore->reveal());
    }
}
