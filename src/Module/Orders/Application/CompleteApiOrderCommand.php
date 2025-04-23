<?php

namespace App\Module\Orders\Application;

final readonly class CompleteApiOrderCommand
{
    public function __construct(
        public int $orderId,
    ) {
    }
}
