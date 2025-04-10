<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Customers\DataProvider\ApiCustomersMapper;
use App\ExternalApi\Customers\DataProvider\CustomersApi;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomersApi::class,
            ApiCustomersMapper::class,
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
                    ApiCustomersMapper::class
                ]
            );

        $container->add(ApiCustomersMapper::class);
    }
}
