<?php

namespace App\Module\Customers\Domain\Customer\Service;

use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\Model\Customer;

class CustomersGeneratorService
{
    public function __construct(
        private CustomerNormalizer $customerSerializer,
        private CustomersApiInterface $customersApi,
    )
    {
    }

    /**
     * @param Customer[] $customerData
     * @return void
     */
    public function generateMultipleCustomers(array $customerData): void
    {
        foreach ($customerData as $customer) {
            $normalizedCustomer = $this
                ->customerSerializer
                ->normalize($customer);

            $this
                ->customersApi
                ->createCustomer($normalizedCustomer);
        }
    }
}