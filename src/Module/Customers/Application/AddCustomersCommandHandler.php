<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;
use App\Module\Customers\Domain\Service\CustomerGeneratorInterface;

readonly class AddCustomersCommandHandler
{
    public function __construct(
        private CustomerDataProviderInterface $customerDataProvider,
        private CustomerGeneratorInterface $customerGenerator,
    ) {
    }

    public function __invoke(AddCustomersCommand $command): void
    {
        $customerData = $this
            ->customerDataProvider
            ->fetchCustomerData();

        $this
            ->customerGenerator
            ->generateMultipleCustomers($customerData);
    }
}
