<?php

namespace App\ExternalApi\Orders\Model;

readonly class ApiOrderItemDto
{
    public function __construct(
        public string $skuId,
        public int $quantity = 1,
    ) {
    }
}
