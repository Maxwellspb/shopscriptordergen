<?php

namespace App\Module\Orders\Domain\Service;

use App\ExternalApi\Orders\Model\ApiOrder;
use App\ExternalApi\Products\Model\ApiProductDto;
use DateTimeImmutable;
use DateTimeInterface;

interface OrdersApiProviderInterface
{
    /**
     * @param int $customerId
     * @param ApiProductDto $productDto
     * @param DateTimeImmutable $createDatetime
     * @return int
     */
    public function placeOrder(
        int $customerId,
        ApiProductDto $productDto,
        DateTimeInterface $createDatetime,
    ): int;

    /**
     * @param int $orderId
     * @return void
     */
    public function completeOrder(int $orderId): void;

    /**
     * @param DateTimeInterface $createDatetime
     * @return ApiOrder[]
     */
    public function searchOrdersByDate(DateTimeInterface $createDatetime): array;

    /**
     * @param int $apiOrderId
     * @return void
     */
    public function refundOrder(int $apiOrderId): void;
}
