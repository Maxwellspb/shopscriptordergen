<?php

namespace App\ExternalApi\Customers\Model;

readonly class ApiCustomerDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $sex,
        public float $affiliateBonus = 0.00
    ) {
    }
}
