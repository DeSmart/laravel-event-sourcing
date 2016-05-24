<?php

namespace DeSmart\EventSourcing\Laravel\Projections;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/read-model.php' => config_path('read-model.php'),
        ]);
    }
    
    /**
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectionManager::class, function () {
            $projectionManager = new ProjectionManager();

            foreach ($this->app['config']['read-model']['projections'] as $projectionClass) {
                $projectionManager->registerProjection($this->app->make($projectionClass));
            }

            return $projectionManager;
        });

        $this->commands(\DeSmart\EventSourcing\Laravel\Projections\Console\RebuildProjectionsCommand::class);
    }
}