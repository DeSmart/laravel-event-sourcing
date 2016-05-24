<?php

namespace stubs;

use DeSmart\EventSourcing\AggregateRootIdInterface;
use DeSmart\EventSourcing\AggregateRootIdTrait;

class BarId implements AggregateRootIdInterface
{
    use AggregateRootIdTrait;
}