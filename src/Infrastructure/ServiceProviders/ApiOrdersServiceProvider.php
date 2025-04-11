<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Orders\Normalizer\ApiOrderNormalizer;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiOrdersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            OrdersApi::class,
            ApiOrderNormalizer::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(OrdersApi::class)
            ->addArguments([
                ApiHttpClient::class,
                ApiOrderNormalizer::class,
            ]);

        $container->add(ApiOrderNormalizer::class);
    }
}
