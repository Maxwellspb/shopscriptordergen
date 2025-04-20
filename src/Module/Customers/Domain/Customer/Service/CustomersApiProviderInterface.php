<?php

namespace App\Module\Customers\Domain\Customer\Service;

use App\ExternalApi\Customers\Model\ApiCustomerDto;

interface CustomersApiProviderInterface
{
    /**
     * @param array $customerData
     * @return ApiCustomerDto
     */
    public function createCustomer(array $customerData): ApiCustomerDto;
}
