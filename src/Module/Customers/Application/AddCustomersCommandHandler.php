<?php

namespace App\Module\Customers\Application;

use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;

class AddCustomersCommandHandler //implements command handler interface
{
    public function __construct(
        private readonly CustomerDataProviderInterface $customerDataProvider,
    )
    {
    }

    public function __invoke(AddCustomersCommand $command)
    {
        $customerData = $this->customerDataProvider->fetchCustomerData();
    }
}