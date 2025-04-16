<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Customer\DataProvider\ApiCustomersProviderInterface;

final readonly class ListApiCustomersQueryHandler
{
    public function __construct(
        private ApiCustomersProviderInterface $customersDataProvider
    )
    {
    }

    public function __invoke(ListApiCustomersQuery $query)
    {
        $customers = $this->customersDataProvider->listCustomers();
    }
}