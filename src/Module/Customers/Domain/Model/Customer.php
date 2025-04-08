<?php

namespace App\Module\Customers\Domain\Model;

readonly class Customer
{
    public function __construct(
        public string $fullName,
        public string $name,
        public string $surname,
        public string $email,
        public string $sex,
    ) {
    }
}
