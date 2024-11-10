<?php

namespace Elsayed85\LmsRedis\Services\StockService\DTO;

class ProductIngredientData
{
    public function __construct(
        public readonly int $product_id,
        public readonly string $ingredient_id,
        public readonly int $quantity,
        public readonly string $status
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            ingredient_id : $data['ingredient_id'],
            quantity : $data['quantity'],
            status : $data['status']
        );
    }
}
