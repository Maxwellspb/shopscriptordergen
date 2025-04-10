<?php

namespace App\Module\Customers\Domain\DataProvider;

use App\Module\Customers\Domain\Model\Customer;

interface CustomersDataProviderInterface
{
    /**
     * @return Customer[]|array
     */
    public function fetchCustomerData(): array;
}
