<?php

namespace Elsayed85\LmsRedis\Services\NotificationService;

use Elsayed85\LmsRedis\LmsRedis;
use Elsayed85\LmsRedis\Traits\HasEvents;

class NotificationRedisService extends LmsRedis
{
    use HasEvents;

    public function getServiceName(): string
    {
        return 'notification';
    }
}
