<?php

namespace App\Module\Customers\Domain\Customer\Service;

interface CustomersApiInterface
{
    public function createCustomer(array $customerData): void;
}
