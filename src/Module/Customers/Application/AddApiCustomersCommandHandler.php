<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;

readonly class AddApiCustomersCommandHandler
{
    public function __construct(
        private CustomersDataProviderInterface $customerDataProvider,
        private CustomersGeneratorService $customersGeneratorService,
    ) {
    }

    public function __invoke(AddApiCustomersCommand $command): void
    {
        $customers = $this
            ->customerDataProvider
            ->fetchCustomerData();

        $this
            ->customersGeneratorService
            ->generateMultipleCustomers($customers);
    }
}
