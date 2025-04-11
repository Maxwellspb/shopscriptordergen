<?php

namespace App\Module\Customers\Domain\Customer\Service;

use App\Module\Customers\Domain\Customer\Model\Customer;

interface CustomersGeneratorInterface
{
    /**
     * @param Customer[] $customerData
     * @return void
     */
    public function generateMultipleCustomers(array $customerData): void;
}
