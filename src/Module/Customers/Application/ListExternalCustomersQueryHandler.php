<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Customer\DataProvider\ExternalCustomersDataProviderInterface;

final readonly class ListExternalCustomersQueryHandler
{
    public function __construct(
        private ExternalCustomersDataProviderInterface $customersDataProvider
    )
    {
    }

    public function __invoke(ListExternalCustomersQuery $query)
    {
        $customers = $this->customersDataProvider->fetchCustomerData();
    }
}