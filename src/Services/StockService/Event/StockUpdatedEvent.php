<?php

namespace Elsayed85\LmsRedis\Services\StockService\Event;

use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Services\StockService\DTO\StockData;
use Elsayed85\LmsRedis\Services\StockService\Enum\StockEvent;

class StockUpdatedEvent extends Event
{
    public StockEvent $type = StockEvent::UPDATED;

    public function __construct(public readonly StockData $data) {}
}
