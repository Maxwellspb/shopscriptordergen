<?php

namespace App\ExternalApi\Products\Model;

class ApiProductDto
{
    public function __construct(
        public readonly int $productId,
        public readonly string $productName,
        public readonly int $skuId,
        public readonly string $sku,
        public readonly float $skuPrice,
    ) {
    }
}
