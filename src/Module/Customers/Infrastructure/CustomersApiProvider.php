<?php

namespace App\Module\Customers\Infrastructure;

use App\ExternalApi\Customers\DataProvider\CreateCustomerRequestDto;
use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\ExternalApi\Customers\Model\ApiCustomerDto;
use App\Module\Customers\Domain\Customer\Service\CustomersApiProviderInterface;

final readonly class CustomersApiProvider implements CustomersApiProviderInterface
{
    public function __construct(
        private CustomersApi $customersApi,
    ) {
    }

    /**
     * @param array $customerData
     * @return ApiCustomerDto
     */
    public function createCustomer(array $customerData): ApiCustomerDto
    {
        $createCustomerRequest = CreateCustomerRequestDto::fromArray($customerData);

        return $this
            ->customersApi
            ->createApiCustomer($createCustomerRequest);
    }
}
