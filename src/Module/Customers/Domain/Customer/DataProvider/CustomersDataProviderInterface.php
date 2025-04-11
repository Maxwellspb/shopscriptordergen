<?php

namespace App\Module\Customers\Domain\Customer\DataProvider;

use App\Module\Customers\Domain\Customer\Model\Customer;

interface CustomersDataProviderInterface
{
    /**
     * @return Customer[]|array
     */
    public function fetchCustomerData(): array;
}
