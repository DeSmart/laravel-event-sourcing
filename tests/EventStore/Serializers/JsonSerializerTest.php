<?php

namespace tests\EventStore\Serializers;

use DeSmart\EventSourcing\Laravel\EventStore\SerializationException;
use DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface;
use DeSmart\EventSourcing\Laravel\EventStore\Serializers\JsonSerializer;
use stubs\PointsWereAdded;

class JsonSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var JsonSerializer
     */
    protected $serializer;

    public function setUp()
    {
        $this->serializer = new JsonSerializer();
    }

    /**
     * @test
     */
    public function it_is_serializer()
    {
        $this->assertInstanceOf(SerializerInterface::class, $this->serializer);
    }

    /**
     * @test
     */
    public function it_serializers_object()
    {
        $event = new PointsWereAdded(350);

        $expected = json_encode(['amount' => 350]);
        $actual = $this->serializer->serialize($event);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_deserializes_data()
    {
        $serializedData = json_encode(['amount' => 350]);
        
        $expected = ['amount' => 350];
        $actual = $this->serializer->deserialize($serializedData);
        
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function it_throws_exception_when_object_is_not_serializable()
    {
        $this->expectException(SerializationException::class);
        $this->expectExceptionMessage('Cannot serialize object of class stdClass');

        $this->serializer->serialize(new \stdClass());
    }
}
