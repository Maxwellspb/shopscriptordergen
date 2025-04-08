<?php

namespace App\Infrastructure\Container;

use App\ExternalApi\ApiClient\ShopApiHttpClient;
use App\ExternalApi\Products\DataProvider\ApiProductMapper;
use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\Infrastructure\CommandHandler\CommandHandler;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\DefinitionContainerInterface;

class ContainerFactory
{
    public static function create(): DefinitionContainerInterface
    {
        $container = new Container();

        $container
            ->addServiceProvider(new PathProvider())
            ->addServiceProvider(new ConfigurationProvider());

        $container
            ->add('command_handler', CommandHandler::class)
            ->addArgument(ProductsApi::class);

        $container
            ->add(ProductsApi::class)
            ->addArguments(
                [
                    ProductApiHttpClientInterface::class,
                    ApiProductMapper::class,
                ]
            );

        $container
            ->add(ProductApiHttpClientInterface::class, ShopApiHttpClient::class)
            ->addArguments(
                [
                    ClientInterface::class,
                    new StringArgument($_ENV['BASE_API_URL']),
                    new StringArgument($_ENV['ADMIN_TOKEN']),
                ]
            );

        $container->add(ApiProductMapper::class);

        $container
            ->add(ClientInterface::class, Client::class);

        return $container;
    }
}
