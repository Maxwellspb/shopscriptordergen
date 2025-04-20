<?php

namespace App\Module\Customers\Domain\Customer\Service;

use App\ExternalApi\Customers\Model\ApiCustomerDto;
use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\Model\Customer;

class CustomersGeneratorService
{
    public function __construct(
        private CustomerNormalizer $customerNormalizer,
        private CustomersApiProviderInterface $customersApiProvider,
    )
    {
    }

    /**
     * @param Customer[] $customerData
     * @return int[]
     */
    public function generateMultipleCustomers(array $customerData): array
    {
        $apiCustomersIds = [];
        foreach ($customerData as $customer) {
             $this->generateSingleCustomer($customer);
        }

        return $apiCustomersIds;
    }

    /**
     * @param Customer $customer
     * @return int|null
     */
    public function generateSingleCustomer(
        Customer $customer
    ): ?int {
        $normalizedCustomer = $this
            ->customerNormalizer
            ->normalize($customer);

        return $this
            ->customersApiProvider
            ->createCustomer($normalizedCustomer);
    }
}
