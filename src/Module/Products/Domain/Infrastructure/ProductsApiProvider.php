<?php

namespace App\Module\Products\Domain\Infrastructure;

use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\ExternalApi\Products\Model\ApiProductDto;
use App\Module\Products\Domain\Service\ProductsApiProviderInterface;

final readonly class ProductsApiProvider implements ProductsApiProviderInterface
{
    public function __construct(
        private ProductsApi $productsApi
    ) {
    }

    /**
     * @return ApiProductDto[]
     */
    public function listProducts(): array
    {
        return $this->productsApi->listProducts();
    }
}