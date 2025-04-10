<?php

namespace App\ExternalApi\Customers\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;

final readonly class CustomersApi
{
    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private ApiCustomersMapper $apiCustomerMapper,
    ) {
    }

    public function createSingleCustomer(array $customerData): void
    {
        $body = [];
        $body['data']['name'] = $customerData['full_name'];
        $body['data']['firstname'] = $customerData['name'];
        $body['data']['lastname'] = $customerData['surname'];
        $body['data']['email'] = $customerData['email'];
        $body['data']['sex'] = $customerData['sex'];

        $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_CUSTOMER_ADD->value,
            $body
        );
    }

    public function listCustomers(): array
    {
        $apiCustomersList = $this->apiHttpClient->get(
            ApiResourcesEnum::SHOP_CUSTOMER_SEARCH->value,
            []
        );

        return $this->apiCustomerMapper->map($apiCustomersList['customers']);
    }
}