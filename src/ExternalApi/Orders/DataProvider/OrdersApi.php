<?php

namespace App\ExternalApi\Orders\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;

final readonly class OrdersApi
{
    public function __construct(
        private ApiHttpClient $apiHttpClient
    )
    {
    }

    public function placeOrder($orderData): void
    {
        $body = [];
        $body['contact_id'] = $orderData['contact_id'];
        $body['items'] = $orderData['items'];
        $body['create_datetime'] = $orderData['create_datetime'];

        $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_ORDER_ADD->value,
            $body
        );
    }
}