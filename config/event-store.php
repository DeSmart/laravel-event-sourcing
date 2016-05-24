<?php

return [
    /*
    |-------------------------------------------------------------------------------------
    | Database Connection For Event Store
    |-------------------------------------------------------------------------------------
    |
    | Specify which database connection should be used for storing events in events store.
    | All database connections can be found in config/database.php configuration file.
    |
    */

    'connection' => null,

    /*
    |-------------------------------------------------------------------------------------
    | Event Store Payload Serializer
    |-------------------------------------------------------------------------------------
    |
    | Serializer used for serializing/deserializing event and it's payload.
    |
    | Payload is usually of array type. It is sufficient to store payload in 
    | JSON format.
    |
    | Supported serializers: 
    | - 'JsonSerializer' -> use for event store that does not have automatic json serialization/deserialization, like mysql databases
    | - 'ArraySerializer -> use for event store that has automatic json serialization/deserialization, like mongodb databases
    |
    */
    
    'serializer' => \DeSmart\EventSourcing\Laravel\EventStore\Serializers\JsonSerializer::class
];