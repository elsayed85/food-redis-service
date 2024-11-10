<?php

namespace Elsayed85\LmsRedis\Services\StockService\DTO;

class ProductIngredientData
{
    public function __construct(
        public readonly int $order_product_id,
        public readonly string $ingredient_id,
        public readonly int $quantity,
        public readonly float $remaining_percentage,
        public readonly string $status
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            order_product_id: $data['order_product_id'],
            ingredient_id : $data['ingredient_id'],
            quantity : $data['quantity'],
            remaining_percentage : $data['remaining_percentage'],
            status : $data['status']
        );
    }
}
