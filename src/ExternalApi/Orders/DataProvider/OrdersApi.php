<?php

namespace App\ExternalApi\Orders\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Orders\Model\AddOrderResponseDto;
use App\ExternalApi\Orders\Model\ApiOrderRequestDto;
use App\ExternalApi\Orders\Normalizer\ApiOrderNormalizer;

final readonly class OrdersApi
{
    private const string ACTION_REFUND = 'refund';

    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private ApiOrderNormalizer $apiOrderNormalizer,
    ) {
    }

    public function addOrder(ApiOrderRequestDto $apiOrderRequestDto): AddOrderResponseDto
    {
        $orderData = $this->apiOrderNormalizer->normalize($apiOrderRequestDto);

        $addOrderResultData = $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_ORDER_ADD->value,
            $orderData
        );

        return AddOrderResponseDto::fromResponse($addOrderResultData);
    }

    public function refundOrder(int $orderId): void
    {
        $orderData = [
            'id' => $orderId,
            'action' => self::ACTION_REFUND
        ];

        $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_ORDER_ACTION->value,
            $orderData
        );
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
