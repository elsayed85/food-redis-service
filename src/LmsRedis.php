<?php

namespace Elsayed85\LmsRedis;

use Carbon\Carbon;
use Elsayed85\LmsRedis\Facades\Redis;
use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Utils\Enum;

abstract class LmsRedis
{
    protected string $allEventsKey = 'events';

    protected string $processedEventsKey = 'processed_events';

    abstract public function getServiceName(): string;

    private function getProcessedEventKey(): string
    {
        return "{$this->getServiceName()}-{$this->processedEventsKey}";
    }

    public function publish(Event $event): void
    {
        Redis::xadd($this->allEventsKey, '*', [
            'event' => $event->toSerializableString(),
            'service' => $this->getServiceName(),
            'created_at' => Carbon::now()->valueOf(),
        ]);
    }

    public function addProcessedEvent(array $event): void
    {
        Redis::rpush($this->getProcessedEventKey(), $event['id']);
    }

    public function getUnProcessedEvents(): array
    {
        $lastProcessedEventId = $this->getLastProcessedEventId() ?: $this->getDefaultStartId();
        $events = $this->getEventsAfter($lastProcessedEventId);

        return $this->parseEvents($events);
    }

    private function getLastProcessedEventId(): ?string
    {
        return Redis::lindex($this->getProcessedEventKey(), -1);
    }

    private function getDefaultStartId(): string
    {
        return (string) Carbon::now()->subYears(10)->valueOf();
    }

    protected function getEventsAfter(string $start): array
    {
        $events = Redis::xRange($this->allEventsKey, $start, Carbon::now()->valueOf());

        if (! $events) {
            return [];
        }

        unset($events[$start]); // Exclude already processed start event

        return $events;
    }

    protected function parseEvents(array $redisEvents): array
    {
        return collect($redisEvents)
            ->map(fn (array $item, string $id) => $this->formatEvent($item, $id))
            ->all();
    }

    private function formatEvent(array $item, string $id): array
    {
        $event = unserialize($item['event']);

        return array_merge($event, [
            'id' => $id,
            'type' => Enum::from($event['type']),
        ]);
    }
}
