<?php

namespace App\Module\Orders\Domain\Service;

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
}
