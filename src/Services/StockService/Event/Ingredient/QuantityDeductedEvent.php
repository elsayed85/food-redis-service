<?php

namespace Elsayed85\LmsRedis\Services\StockService\Event\Ingredient;

use Elsayed85\LmsRedis\Services\Event;
use Elsayed85\LmsRedis\Services\StockService\DTO\ProductIngredientData;
use Elsayed85\LmsRedis\Services\StockService\Enum\IngredientEvent;

class QuantityDeductedEvent extends Event
{
    public IngredientEvent $type = IngredientEvent::DEDUCTED;

    public function __construct(public readonly ProductIngredientData $payload) {}
}
