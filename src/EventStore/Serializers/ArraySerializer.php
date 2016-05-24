<?php

namespace DeSmart\EventSourcing\Laravel\EventStore\Serializers;

use DeSmart\EventSourcing\Laravel\EventStore\SerializationException;
use DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface;
use Illuminate\Contracts\Support\Arrayable;

class ArraySerializer implements SerializerInterface
{
    /**
     * @param Arrayable $object
     * @return array
     * @throws SerializationException
     */
    public function serialize($object)
    {
        if (false === $object instanceof Arrayable) {
            throw new SerializationException(sprintf('Cannot serialize object of class %s', get_class($object)));
        }
        
        return $object->toArray();
    }

    /**
     * @param array $data
     * @return array
     */
    public function deserialize($data)
    {
        return $data;
    }
}