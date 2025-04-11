<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Customer\DataProvider\InternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorInterface;

readonly class AddExternalCustomersCommandHandler
{
    public function __construct(
        private InternalCustomersDataProviderInterface $customerDataProvider,
        private CustomersGeneratorInterface $customerGenerator,
    ) {
    }

    public function __invoke(AddExternalCustomersCommand $command): void
    {
        $customerData = $this
            ->customerDataProvider
            ->fetchCustomerData();

        $this
            ->customerGenerator
            ->generateMultipleCustomers($customerData);
    }
}
