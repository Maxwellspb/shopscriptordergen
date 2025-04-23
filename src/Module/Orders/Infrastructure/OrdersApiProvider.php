<?php

namespace App\Module\Orders\Infrastructure;

use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Orders\Model\ApiOrderItemDto;
use App\ExternalApi\Orders\Model\ApiOrderRequestDto;
use App\ExternalApi\Products\Model\ApiProductDto;
use App\Module\Common\Service\Generator\BooleanGenerator;
use App\Module\Orders\Domain\Service\OrdersApiProviderInterface;
use DateTimeInterface;

final readonly class OrdersApiProvider implements OrdersApiProviderInterface
{
    public function __construct(
        private OrdersApi $ordersApi,
    ) {
    }

    public function placeOrder(
        int $customerId,
        ApiProductDto $productDto,
        DateTimeInterface $createDatetime,
    ): int {
        $orderRequest = new ApiOrderRequestDto(
            $customerId,
            $createDatetime,
            BooleanGenerator::averageTrue(),
            [
                new ApiOrderItemDto(
                    $productDto->skuId,
                    array_rand([1, 2, 3])
                )
            ]
        );

        $orderResponse = $this->ordersApi->addOrder($orderRequest);

        return $orderResponse->orderId;
    }

    public function completeOrder(int $orderId): void
    {
        $this->ordersApi->completeOrder($orderId);
    }
}
