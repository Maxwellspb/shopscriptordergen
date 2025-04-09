<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;

readonly class AddCustomersCommandHandler
{
    public function __construct(
        private CustomerDataProviderInterface $customerDataProvider,
    )
    {
    }

    public function __invoke(AddCustomersCommand $command)
    {
        $customerData = $this->customerDataProvider->fetchCustomerData();
    }
}
