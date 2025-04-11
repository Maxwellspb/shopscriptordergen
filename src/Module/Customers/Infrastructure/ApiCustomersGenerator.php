<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Customer\DataProvider\CustomerNormalizer;
use App\Module\Customers\Domain\Customer\Model\Customer;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorInterface;

final readonly class ApiCustomersGenerator implements CustomersGeneratorInterface
{
    public function __construct(
        private CustomersApi $customersApi,
        private CustomerNormalizer $customerSerializer,
    ) {
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
                ->createSingleCustomer($normalizedCustomer);
        }
    }
}
