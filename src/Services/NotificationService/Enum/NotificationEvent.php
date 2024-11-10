<?php

namespace Elsayed85\LmsRedis\Services\NotificationService\Enum;

enum NotificationEvent: string
{
    case CREATED = 'notification:pushed';
}
