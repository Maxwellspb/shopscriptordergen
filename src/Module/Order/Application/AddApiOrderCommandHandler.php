<?php

namespace App\Module\Order\Application;

use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Orders\Model\ApiOrderDto;
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
        $apiOrder = new ApiOrderDto(
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
