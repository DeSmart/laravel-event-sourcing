<?php

namespace stubs;

use DeSmart\EventSourcing\AggregateRootIdInterface;
use DeSmart\EventSourcing\EventInterface;
use DeSmart\EventSourcing\SerializableInterface;
use Illuminate\Contracts\Support\Arrayable;

class PointsWereAdded implements EventInterface, Arrayable, SerializableInterface
{
    protected $amount = 0;

    /**
     * @param int $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return AggregateRootIdInterface
     */
    public function getAggregateRootId()
    {
        return new BarId('BarId');
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'amount' => $this->amount
        ];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->jsonSerialize();
    }

    /**
     * @param array $payload
     * @return PointsWereAdded
     */
    public static function createFromPayload(array $payload)
    {
        return new PointsWereAdded($payload['amount']);
    }
}