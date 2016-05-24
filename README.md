# Laravel Event Sourcing

Simple Laravel implementation of event sourcing mechanism.

_**Be advised:**_ this package is work in progress and some breaking changes may appear on the way.

Package realizes concept of event sourcing with Laravel framework. Package consists of two main elements: 
implementation of database-like event store and projection manager.

Event store is a append-only storage dedicated for storing events.
Projection manager allows to register projections and update them with generated stream of events.

## Installation
To install the package via Composer, simply run the following command:
```
composer require desmart/laravel-event-sourcing
```

In order to use provided event store implementation, register service provider in your `config/app.php` file:
```php
'providers' => [
    // ...
    
    DeSmart\EventSourcing\Laravel\EventStore\ServiceProvider::class,
]
```

In order to use projection manager, register service provider in your `config/app.php` file:
```php
'providers' => [
    // ...
    
    DeSmart\EventSourcing\Laravel\Projections\ServiceProvider::class,
]
```

After registering service provider(s), run artisan command to publish configuration files:
```php
php artisan vendor:publish
```
## Configuration
Package adds two configuration files: `event-store.php` and `read-model.php`.
### `event-store.php`
Here you can configure:
 - which connection will be used to connect with your event store,
 - which event's payload serializer will be used.
```php
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
```

### `read-model.php`
Here you can register all projections that should be notified with stream of events.
```php
return [
    /*
    |--------------------------------------------------------------------------
    | Read Model Projections
    |--------------------------------------------------------------------------
    |
    | Array of projection classes.
    |
    | These projections will be notified about saved stream of events and they
    | can react with read model updates.
    |
    */
    
    'projections' => []
];
```

## Event store implementation
This package's event store implementation was successfully used/tested with MySql database, MongoDB database as well as 
with mix of the two: one database served as an event store, where second was storing projections.

## License
Package is released under the MIT License (MIT). Please, check [LICENSE](https://github.com/desmart/event-sourcing/blob/master/LICENSE) for more details.