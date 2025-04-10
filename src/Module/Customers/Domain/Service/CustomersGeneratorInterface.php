<?php

namespace App\Module\Customers\Domain\Service;

use App\Module\Customers\Domain\Model\Customer;

interface CustomersGeneratorInterface
{
    /**
     * @param Customer[] $customerData
     * @return void
     */
    public function generateMultipleCustomers(array $customerData): void;
}
