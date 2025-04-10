<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Customers\DataProvider\CustomersApi;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiCustomersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            CustomersApi::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(CustomersApi::class)
            ->addArgument(ApiHttpClient::class);
    }
}
