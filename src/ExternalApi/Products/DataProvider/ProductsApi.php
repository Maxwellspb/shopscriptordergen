<?php

namespace App\ExternalApi\Products\DataProvider;

use App\ExternalApi\Products\Model\ApiProductDto;
use Throwable;

class ProductsApi
{
    private const string FIELDS_PARAM_KEY = 'fields';
    private const string FIELDS_SKUS_PARAM = 'skus';

    public function __construct(
        private readonly ProductApiHttpClient $httpClient
    )
    {

    }


    /**
     * @return ApiProductDto[]
     */
    public function listProducts(): array
    {
         $productData = $this->httpClient->get(
            ProductApiResourcesEnum::SHOP_PRODUCT_SEARCH->value,
            [
                self::FIELDS_PARAM_KEY => self::FIELDS_SKUS_PARAM
            ]
        );

         $a = 1;
    }
}
