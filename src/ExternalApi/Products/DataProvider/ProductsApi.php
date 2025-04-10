<?php

namespace App\ExternalApi\Products\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Products\Model\ApiProductDto;

class ProductsApi
{
    private const string FIELDS_PARAM_KEY = 'fields';
    private const string FIELDS_SKUS_PARAM = 'skus';

    public function __construct(
        private readonly ApiHttpClient $apiHttpClient,
        private readonly ApiProductMapper $apiProductMapper,
    ) {
    }

    /**
     * @return ApiProductDto[]
     */
    public function listProducts(): array
    {
        $productData = $this->apiHttpClient->get(
            ApiResourcesEnum::SHOP_PRODUCT_SEARCH->value,
            [
                self::FIELDS_PARAM_KEY => self::FIELDS_SKUS_PARAM
            ]
        );

        if (!array_key_exists('products', $productData)) {
            return [];
        }

        return $this->apiProductMapper->map($productData['products']);
    }
}
