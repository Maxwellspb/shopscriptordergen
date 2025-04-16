<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\Service\CustomersApiInterface;

final readonly class CustomersApiAdapter implements CustomersApiInterface
{
    public function __construct(
        private CustomersApi $customersApi,
    ) {
    }

    /**
     * @param array $customerData
     * @return void
     */
    public function createCustomer(array $customerData): void
    {
        $this->customersApi->createCustomer($customerData);
    }
}
