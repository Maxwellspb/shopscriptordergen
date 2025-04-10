<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\Module\Customers\Domain\Service\CustomerGeneratorInterface;
use App\Module\Customers\Domain\Service\CustomerNormalizer;

final readonly class ApiCustomerGenerator implements CustomerGeneratorInterface
{
    public function __construct(
        private CustomersApi $customersApi,
        private CustomerNormalizer $customerSerializer,
    ) {
    }

    /** inherit */
    public function generateMultipleCustomers(array $customerData): void
    {
        foreach ($customerData as $customer) {
            $serializedCustomer = $this
                ->customerSerializer
                ->normalize($customer);

            $this
                ->customersApi
                ->createSingleCustomer($serializedCustomer);
        }
    }
}
