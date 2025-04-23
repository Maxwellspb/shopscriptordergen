<?php

namespace App\Module\Orders\Application;

readonly class RefundApiOrderCommand
{
    public function __construct(
        public int $orderId
    ) {
    }
}
