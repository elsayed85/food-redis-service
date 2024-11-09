<?php

namespace Elsayed85\LmsRedis\Services\OrderService\DTO;

class OrderItemData
{
    public function __construct(
        public readonly string $product_id,
        public readonly int $quantity
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            quantity: $data['quantity']
        );
    }
}
