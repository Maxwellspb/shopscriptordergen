<?php

namespace App\Module\Order\Application;

readonly class RefundApiOrderCommand
{
    public function __construct(
        public int $orderId
    ) {
    }
}
