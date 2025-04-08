<?php

namespace App\ExternalApi\Products\DataProvider;

use App\ExternalApi\Products\Model\ApiProductDto;

class ApiProductMapper
{
    /**
     * @param array $productData
     * @return ApiProductDto[]
     */
    public function map(array $productData): array
    {
        if (empty($productData)) {
            return [];
        }

        $productCollection = [];
        foreach ($productData as $product) {
            foreach ($product['skus'] as $sku) {
                $productCollection[] = new ApiProductDto(
                    (int)$product['id'],
                    $product['name'],
                    $sku['id'],
                    $sku['sku'],
                    (float)$sku['price'],
                );
            }
        }

        return $productCollection;
    }
}
