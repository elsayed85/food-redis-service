<?php

namespace Elsayed85\LmsRedis\Services\StockService\Enum;

enum StockEvent: string
{
    case CREATED = 'stock:created';
    case UPDATED = 'stock:updated';
    case DELETED = 'stock:deleted';
}
