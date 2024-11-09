<?php

namespace Elsayed85\LmsRedis\Services\OrderService\Enum;

enum OrderEvent: string
{
    case CREATED = 'order:created';
    case UPDATED = 'order:updated';
}
