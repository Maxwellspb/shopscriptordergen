<?php

namespace App\ExternalApi\Orders\Model;

final readonly class ApiOrder
{
    public function __construct(
        public int $id,
        public int $contactId,
        public \DateTimeInterface $createDatetime,
        public float $total,
        public string $stateId,
    ) {
    }
}