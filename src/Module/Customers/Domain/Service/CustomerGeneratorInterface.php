<?php

namespace App\Module\Customers\Domain\Service;

use App\Module\Customers\Domain\Model\Customer;

interface CustomerGeneratorInterface
{
    /**
     * @param Customer[] $customerData
     * @return void
     */
    public function generateMultipleCustomers(array $customerData): void;
}
