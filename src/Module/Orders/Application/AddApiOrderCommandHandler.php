<?php

namespace App\Module\Orders\Application;

use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Orders\Model\ApiOrderRequestDto;
use App\ExternalApi\Orders\Model\ApiOrderItemDto;
use DateTime;

final readonly class AddApiOrderCommandHandler
{
    public function __construct(
        private OrdersApi $ordersApi
    ) {
    }

    public function __invoke(AddApiOrderCommand $command)
    {
        $apiOrder = new ApiOrderRequestDto(
            1,
            new DateTime('2024-07-01 15:00:00'),
            true,
            [
                new ApiOrderItemDto(
                    363,
                    1
                )
            ]
        );

        $orderResultSDto = $this->ordersApi->addOrder($apiOrder);
    }
}
