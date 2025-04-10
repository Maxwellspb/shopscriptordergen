<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\ApiClient\ApiHttpClient;
use App\ExternalApi\Products\DataProvider\ApiProductMapper;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use GuzzleHttp\ClientInterface;
use League\Container\Argument\Literal\StringArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ApiProductsServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            ProductsApi::class,
            ApiHttpClient::class,
            ApiProductMapper::class
        ];

        return in_array($id, $services);
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container
            ->add(ProductsApi::class)
            ->addArguments(
                [
                    ApiHttpClient::class,
                    ApiProductMapper::class,
                ]
            );

        $container
            ->add(ApiHttpClient::class)
            ->addArguments(
                [
                    ClientInterface::class,
                    new StringArgument($_ENV['BASE_API_URL']),
                    new StringArgument($_ENV['ADMIN_TOKEN']),
                ]
            );

        $container->add(ApiProductMapper::class);
    }
}
