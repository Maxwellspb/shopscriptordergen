<?php

namespace App\Module\Orders\Application;

use App\ExternalApi\Orders\DataProvider\OrdersApi;

final readonly class CompleteApiOrderCommandHandler
{
    public function __construct(
        private OrdersApi $ordersApi,
    ) {
    }

    public function __invoke(CompleteApiOrderCommand $command): void
    {
        $this->ordersApi->completeOrder($command->orderId);
    }
}
