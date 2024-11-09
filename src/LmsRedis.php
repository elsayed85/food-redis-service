<?php

namespace Elsayed85\LmsRedis;

use Carbon\Carbon;
use Elsayed85\LmsRedis\Facades\Redis;
use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Utils\Enum;

abstract class LmsRedis
{
    protected string $allEventsChannel = 'events_channel';

    abstract public function getServiceName(): string;

    public function publish(Event $event): void
    {
        Redis::publish($this->allEventsChannel, json_encode([
            'event' => $event->toJson(),
            'service' => $this->getServiceName(),
            'created_at' => Carbon::now()->toIso8601String(),
        ]));
    }

    public function subscribe(callable $callback): void
    {
        Redis::subscribe([$this->allEventsChannel], function ($message) use ($callback) {
            $decodedMessage = json_decode($message, true);
            if ($decodedMessage && isset($decodedMessage['event'])) {
                $event = $this->parseEvent($decodedMessage);
                $callback($event);
            }
        });
    }

    protected function parseEvent(array $redisMessage): array
    {
        $eventData = json_decode($redisMessage['event'], true);

        return array_merge($eventData, [
            'service' => $redisMessage['service'],
            'created_at' => $redisMessage['created_at'],
            'type' => Enum::from($eventData['type']),
        ]);
    }
}
