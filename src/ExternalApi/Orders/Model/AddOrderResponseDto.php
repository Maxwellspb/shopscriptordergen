<?php

namespace App\ExternalApi\Orders\Model;

use DateTime;
use DateTimeInterface;

readonly class AddOrderResponseDto
{
    public function __construct(
        public int $orderId,
        public int $contactId,
        public DateTimeInterface $creatDatetime,
        public float $total,
        public float $discount,
    ) {
    }

    public static function fromResponse(array $response): AddOrderResponseDto
    {
        return new self(
            (int) $response['id'],
            (int) $response['contact_id'],
            new DateTime($response['create_datetime']),
            (float) $response['total'],
            (float) $response['discount'],
        );
    }
}
