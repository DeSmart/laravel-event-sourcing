<?php

namespace example\Domain;

use DeSmart\EventSourcing\AggregateRootIdInterface;
use DeSmart\EventSourcing\AggregateRootIdTrait;

class UserId implements AggregateRootIdInterface
{
    use AggregateRootIdTrait;
}