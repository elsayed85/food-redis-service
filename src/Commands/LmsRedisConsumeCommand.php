<?php

namespace App\Console\Commands;

use Elsayed85\LmsRedis\LmsRedis;
use Illuminate\Console\Command;

class LmsRedisConsumeCommand extends Command
{
    public $signature = 'lms:consume';

    public $description = 'Consume events from Redis Pub/Sub';

    protected LmsRedis $redisService;

    public function __construct()
    {
        parent::__construct();
        $this->redisService = $this->getLmsServiceClass();
    }

    private function getLmsServiceClass(): LmsRedis
    {
        $service = config('lms-redis.service');

        return new $service;
    }

    public function handle(): void
    {
        $this->redisService->subscribe(function ($event) {
            match ($event['type']) {
                // Handle your events here
                // ProductEvent::CREATED => $this->handleProductCreatedEvent($event),
                default => null
            };
        });
    }
}
