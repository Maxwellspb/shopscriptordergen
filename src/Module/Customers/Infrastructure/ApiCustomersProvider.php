<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\ApiCustomersProviderInterface;

final readonly class ApiCustomersProvider implements ApiCustomersProviderInterface
{
    public function __construct(
        private CustomersApi $customersApi,
    ) {
    }

    public function listCustomers(): array
    {
        return $this->customersApi->listCustomers();
    }
}
