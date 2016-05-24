<?php

namespace DeSmart\EventSourcing\Laravel\EventStore;

interface SerializerInterface
{
    /**
     * @param object $object
     * @return mixed
     * @throws SerializationException
     */
    public function serialize($object);

    /**
     * @param mixed $data
     * @return mixed
     */
    public function deserialize($data);
}