<?php

namespace App\Module\Orders\Application;

use App\ExternalApi\Orders\DataProvider\OrdersApi;

final readonly class RefundApiOrderCommandHandler
{
    public function __construct(
        private OrdersApi $ordersApi,
    ) {
    }

    public function __invoke(RefundApiOrderCommand $command)
    {
        $this->ordersApi->refundOrder($command->orderId);
        $a = 1;
    }
}
