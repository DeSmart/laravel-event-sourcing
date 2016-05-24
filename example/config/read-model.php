<?php

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
    
    'projections' => [
        \example\WebPlugin\UsersProjection::class,
    ]
];