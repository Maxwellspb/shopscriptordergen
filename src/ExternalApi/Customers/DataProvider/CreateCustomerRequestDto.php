<?php

namespace App\ExternalApi\Customers\DataProvider;

use DateTimeInterface;

readonly class CreateCustomerRequestDto
{
    public function __construct(
        public string $name,
        public string $firstname,
        public string $lastname,
        public string $email,
        public DateTimeInterface $createDatetime,
    ) {
    }

    public static function fromArray(array $customerData): CreateCustomerRequestDto
    {
        return new self(
            name: $customerData['name'],
            firstname: $customerData['firstname'],
            lastname: $customerData['lastname'],
            email: $customerData['email'],
            createDatetime: $customerData['createDatetime'],
        );
    }
}
