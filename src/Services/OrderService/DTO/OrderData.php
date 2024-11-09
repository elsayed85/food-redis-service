<?php

namespace Elsayed85\LmsRedis\Services\OrderService\DTO;

class OrderData
{
    public function __construct(
        public readonly int $id,
        public readonly array $items = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            items: array_map(fn ($item) => OrderItemData::fromArray($item), $data['items'])
        );
    }
}
