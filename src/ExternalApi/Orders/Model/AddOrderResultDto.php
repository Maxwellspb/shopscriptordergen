<?php

namespace App\ExternalApi\Orders\Model;

use DateTimeInterface;

readonly class AddOrderResultDto
{
    public function __construct(
        public int $orderId,
        public int $contactId,
        public DateTimeInterface $creatDatetime,
        public float $total,
        public float $discount,
    ) {
    }
}
