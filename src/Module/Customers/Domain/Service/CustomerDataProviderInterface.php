<?php

namespace App\Module\Customers\Domain\Service;

use App\Module\Customers\Domain\Model\Customer;

interface CustomerDataProviderInterface
{
    /**
     * @return Customer[]|array
     */
    public function fetchCustomerData(): array;
}
