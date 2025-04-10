<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Orders\DataProvider\OrdersApi;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiOrdersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            OrdersApi::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(OrdersApi::class)
            ->addArgument(ApiHttpClient::class);
    }
}
