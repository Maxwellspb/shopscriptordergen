<?php

namespace App\Module\Customers\Domain\Customer\Service;

use App\ExternalApi\Customers\Model\ApiCustomerDto;

interface CustomersApiProviderInterface
{
    /**
     * @param array $customerData
     * @return int|null
     */
    public function createCustomer(array $customerData): ?int;
}
