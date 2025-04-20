<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\ExternalApi\Customers\Normalizer\ApiCustomerNormalizer;
use App\ExternalApi\Customers\Normalizer\CreateCustomerRequestNormalizer;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomersApi::class,
            ApiCustomerNormalizer::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(CustomersApi::class)
            ->addArguments(
                [
                    ApiHttpClient::class,
                    CreateCustomerRequestNormalizer::class,
                    ApiCustomerNormalizer::class,
                ]
            );

        $container
            ->add(ApiCustomerNormalizer::class);

        $container
            ->add(CreateCustomerRequestNormalizer::class);
    }
}
