<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\ExternalCustomersDataProviderInterface;

final readonly class ApiCustomersDataProvider implements ExternalCustomersDataProviderInterface
{
    public function __construct(
        private CustomersApi $customersApi,
    ) {
    }

    public function fetchCustomerData(): array
    {
        $apiCustomers = $this->customersApi->listCustomers();
        print_r($apiCustomers);
    }
}
