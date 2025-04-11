<?php

namespace App\ExternalApi\Orders\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Orders\Model\AddOrderResultDto;
use App\ExternalApi\Orders\Model\ApiOrderDto;
use App\ExternalApi\Orders\Normalizer\ApiOrderNormalizer;

final readonly class OrdersApi
{
    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private ApiOrderNormalizer $apiOrderNormalizer,
    ) {
    }

    public function addOrder(ApiOrderDto $apiOrderDto): AddOrderResultDto
    {
        $orderData = $this->apiOrderNormalizer->normalize($apiOrderDto);

        $addOrderResultData = $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_ORDER_ADD->value,
            $orderData
        );

        return AddOrderResultDto::fromResponse($addOrderResultData);
    }

    public function completeOrder(int $orderId): void
    {
        $orderData = ['id' => $orderId];

        $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_ORDER_COMPLETE->value,
            $orderData
        );
    }
}
