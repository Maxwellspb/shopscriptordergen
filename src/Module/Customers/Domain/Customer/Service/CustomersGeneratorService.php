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
     * @return ApiCustomerDto[]
     */
    public function generateMultipleCustomers(array $customerData): array
    {
        $apiCustomers = [];
        foreach ($customerData as $customer) {
            $apiCustomers[] = $this->generateSingleCustomer($customer);
        }

        return $apiCustomers;
    }

    /**
     * @param Customer $customer
     * @return ApiCustomerDto
     */
    public function generateSingleCustomer(
        Customer $customer
    ): ApiCustomerDto {
        $normalizedCustomer = $this
            ->customerNormalizer
            ->normalize($customer);

        return $this
            ->customersApiProvider
            ->createCustomer($normalizedCustomer);
    }
}
