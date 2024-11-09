<?php

namespace Elsayed85\LmsRedis\Services\OrderService;

use Elsayed85\LmsRedis\LmsRedis;
use Elsayed85\LmsRedis\Traits\HasEvents;

class OrderRedisService extends LmsRedis
{
    use HasEvents;

    public function getServiceName(): string
    {
        return 'order';
    }
}
