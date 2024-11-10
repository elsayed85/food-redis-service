<?php

namespace Elsayed85\LmsRedis\Services\StockService\Enum;

enum IngredientEvent: string
{
    case DEDUCTED = 'ingredient:deducted';
}
