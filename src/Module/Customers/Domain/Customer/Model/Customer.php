<?php

namespace App\Module\Customers\Domain\Customer\Model;

readonly class Customer
{
    public function __construct(
        public string $name,
        public string $firstName,
        public string $lastName,
        public string $email,
    ) {
    }
}
