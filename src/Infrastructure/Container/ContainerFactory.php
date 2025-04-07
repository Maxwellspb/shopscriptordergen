<?php

namespace App\Infrastructure\Container;

use App\ExternalApi\Products\DataProvider\ProductApiHttpClient;
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
            ->addArgument(ProductApiHttpClientInterface::class);

        $container
            ->add(ProductApiHttpClientInterface::class, ProductApiHttpClient::class)
            ->addArguments(
                [
                    ClientInterface::class,
                    new StringArgument($_ENV['BASE_API_URL']),
                ]
            );

        $container
            ->add(ClientInterface::class, Client::class);

        return $container;
    }
}
