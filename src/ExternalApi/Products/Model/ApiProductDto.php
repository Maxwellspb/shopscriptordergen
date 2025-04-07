<?php

namespace App\ExternalApi\Products\Model;

readonly class ApiProductDto
{
    public function __construct(
        public int $productId,
        public string $productName,
        public int $skuId,
        public string $sku,
        public float $skuPrice,
    ) {
    }
}
