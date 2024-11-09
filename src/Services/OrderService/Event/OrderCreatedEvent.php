<?php

namespace Elsayed85\LmsRedis\Services\OrderService\Event;

use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Services\OrderService\DTO\OrderData;
use Elsayed85\LmsRedis\Services\OrderService\Enum\OrderEvent;

class OrderCreatedEvent extends Event
{
    public OrderEvent $type = OrderEvent::CREATED;

    public function __construct(public readonly OrderData $data)
    {
    }
}
