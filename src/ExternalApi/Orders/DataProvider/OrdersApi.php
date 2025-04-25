<?php

namespace App\ExternalApi\Orders\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Orders\Model\AddOrderResponseDto;
use App\ExternalApi\Orders\Model\ApiOrderRequestDto;
use App\ExternalApi\Orders\Normalizer\AddApiOrderRequestNormalizer;
use App\ExternalApi\Orders\Normalizer\ApiOrderNormalizer;
use DateTimeInterface;

final readonly class OrdersApi
{
    private const string ACTION_REFUND = 'refund';

    private const string FIELDS_PARAM_KEY = 'hash';

    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private AddApiOrderRequestNormalizer $apiOrderRequestNormalizer,
        private ApiOrderNormalizer $apiOrderNormalizer,
    ) {
    }

    public function addOrder(ApiOrderRequestDto $apiOrderRequestDto): AddOrderResponseDto
    {
        $orderData = $this->apiOrderRequestNormalizer->normalize($apiOrderRequestDto);

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

    public function searchOrdersByDate(DateTimeInterface $createDatetime): array
    {
        $orderData = $this->apiHttpClient->get(
            ApiResourcesEnum::SHOP_ORDER_SEARCH->value,
            [
                self::FIELDS_PARAM_KEY => sprintf('search/create_datetime*=%s', $createDatetime->format('Y-m-d')),
            ]
        );

        return array_map(
            fn (array $orderItem) => $this
                ->apiOrderNormalizer
                ->denormalize($orderItem),
            $orderData['orders'],
        );
    }
}
