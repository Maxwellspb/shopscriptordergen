<?php

namespace App\ExternalApi\Orders\Normalizer;

use App\ExternalApi\Orders\Model\ApiOrder;

class ApiOrderNormalizer
{
    public function denormalize(array $apiOrderData): ApiOrder
    {
        return new ApiOrder(
            (int)$apiOrderData['id'],
            (int)$apiOrderData['contact_id'],
            new \DateTime($apiOrderData['create_datetime']),
            (float)$apiOrderData['total'],
            $apiOrderData['state_id']
        );
    }
}
