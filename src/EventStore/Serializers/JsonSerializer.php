<?php

namespace DeSmart\EventSourcing\Laravel\EventStore\Serializers;

use DeSmart\EventSourcing\Laravel\EventStore\SerializationException;
use DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface;

class JsonSerializer implements SerializerInterface
{
    /**
     * @param \JsonSerializable $object
     * @return string
     * @throws SerializationException
     */
    public function serialize($object)
    {
        if (false === $object instanceof \JsonSerializable) {
            throw new SerializationException(sprintf('Cannot serialize object of class %s', get_class($object)));
        }
        
        return json_encode($object);
    }

    /**
     * @param string $data
     * @return array
     */
    public function deserialize($data)
    {
        return json_decode($data, true);
    }
}