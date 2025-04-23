<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Customer\DataProvider\ApiCustomersProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersApiProviderInterface;

final readonly class ListApiCustomersQueryHandler
{
    public function __construct(
        private CustomersApiProviderInterface $customersApiProvider
    )
    {
    }

    public function __invoke(ListApiCustomersQuery $query)
    {
        $customers = $this->customersApiProvider->listCustomers();
    }
}