<?php

namespace App\ExternalApi\Orders\Model;

use DateTimeInterface;

readonly class ApiOrderDto
{
    public function __construct(
        public int $contactId,
        public DateTimeInterface $creatDatetime,
        public bool $forceAffiliate = false,
        public array $orderItems = [],
    ) {
    }
}
