<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\Module\Products\Domain\Infrastructure\ProductsApiProvider;
use App\Module\Products\Domain\Service\ProductsApiProviderInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ModuleProductsServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            ProductsApiProviderInterface::class,
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(ProductsApiProviderInterface::class, ProductsApiProvider::class)
            ->addArgument(ProductsApi::class);
    }
}