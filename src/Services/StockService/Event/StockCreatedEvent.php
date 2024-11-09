<?php

namespace Elsayed85\LmsRedis\Services\StockService\Event;

use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Services\StockService\DTO\StockData;
use Elsayed85\LmsRedis\Services\StockService\Enum\StockEvent;

class StockCreatedEvent extends Event
{
    public StockEvent $type = StockEvent::CREATED;

    public function __construct(public readonly StockData $data)
    {
    }
}
