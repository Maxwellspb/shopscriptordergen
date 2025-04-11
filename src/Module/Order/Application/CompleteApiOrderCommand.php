<?php

namespace App\Module\Order\Application;

final readonly class CompleteApiOrderCommand
{
    public function __construct(
        public string $orderId,
    ) {
    }
}
