<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\Module\Orders\Domain\Service\OrdersApiProviderInterface;
use App\Module\Orders\Infrastructure\OrdersApiProvider;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleOrdersServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            OrdersApiProviderInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(OrdersApiProviderInterface::class, OrdersApiProvider::class)
            ->addArgument(OrdersApi::class);
    }
}
