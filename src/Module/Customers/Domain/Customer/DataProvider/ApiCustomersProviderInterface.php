<?php

namespace App\Module\Customers\Domain\Customer\DataProvider;

use App\ExternalApi\Customers\Model\ApiCustomerDto;

interface ApiCustomersProviderInterface
{
    /**
     * @return ApiCustomerDto[]
     */
    public function listCustomers(): array;
}
