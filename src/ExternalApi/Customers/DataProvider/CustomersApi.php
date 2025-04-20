<?php

namespace App\ExternalApi\Customers\DataProvider;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\ApiClient\ApiResourcesEnum;
use App\ExternalApi\Customers\Model\ApiCustomerDto;
use App\ExternalApi\Customers\Normalizer\ApiCustomerNormalizer;
use App\ExternalApi\Customers\Normalizer\CreateCustomerRequestNormalizer;

final readonly class CustomersApi
{
    public function __construct(
        private ApiHttpClient $apiHttpClient,
        private CreateCustomerRequestNormalizer $createCustomerRequestNormalizer,
        private ApiCustomerNormalizer $apiCustomerNormalizer,
    ) {
    }

    public function createApiCustomer(CreateCustomerRequestDto $apiCustomerDto): ?int
    {
        $body = [];

        $body['data'] = $this
            ->createCustomerRequestNormalizer
            ->normalize($apiCustomerDto);

        $apiCustomerData = $this->apiHttpClient->post(
            ApiResourcesEnum::SHOP_CUSTOMER_ADD->value,
            $body
        );

        return $apiCustomerData['contact_id'] ?? null;
    }

    /**
     * todo add query context, what, how many
     * @return ApiCustomerDto[]
     */
    public function listCustomers(): array
    {
        $apiCustomersList = $this->apiHttpClient->get(
            ApiResourcesEnum::SHOP_CUSTOMER_SEARCH->value,
            []
        );

        return array_map(
            static fn (array $apiCustomerData) => $this
                ->apiCustomerNormalizer
                ->denormalize($apiCustomerData),
            $apiCustomersList['customers']
        );
    }
}
