<?php

namespace App\ExternalApi\Customers\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Customers\Model\ApiCustomerDto;

final readonly class CustomersApi
{
    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private ApiCustomersMapper $apiCustomerMapper,
    ) {
    }

    public function createCustomer(array $customerData): void
    {
        $body = [];
        $body['data']['name'] = $customerData['name'];
        $body['data']['firstname'] = $customerData['name'];
        $body['data']['lastname'] = $customerData['surname'];
        $body['data']['email'] = $customerData['email'];
        $body['data']['create_datetime'] = '2023-01-01 12:00:00';

        $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_CUSTOMER_ADD->value,
            $body
        );
    }

    /**
     * @return ApiCustomerDto[]
     */
    public function listCustomers(): array
    {
        $apiCustomersList = $this->apiHttpClient->get(
            ApiResourcesEnum::SHOP_CUSTOMER_SEARCH->value,
            []
        );

        return $this->apiCustomerMapper->map($apiCustomersList['customers']);
    }
}
