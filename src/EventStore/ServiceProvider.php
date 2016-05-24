<?php

namespace DeSmart\EventSourcing\Laravel\EventStore;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/event-store.php' => config_path('event-store.php'),
        ]);
    }
    
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(\DeSmart\EventSourcing\EventStoreInterface::class, function () {
            /** @var \Illuminate\Database\DatabaseManager $db */
            $db = $this->app['db'];
            
            return new DbEventStore(
                $db->connection($this->app['config']['event-store']['connection']), 
                $this->app->make(\DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface::class)
            );
        });    
        
        $this->app->bind(\DeSmart\EventSourcing\Laravel\EventStore\SerializerInterface::class, function () {
            return $this->app->make($this->app['config']['event-store']['serializer']);
        });
    }
}