<?php

namespace Elsayed85\LmsRedis\Services\StockService;

use Elsayed85\LmsRedis\LmsRedis;
use Elsayed85\LmsRedis\Traits\HasEvents;

class StockRedisService extends LmsRedis
{
    use HasEvents;

    public function getServiceName(): string
    {
        return 'stock';
    }
}
