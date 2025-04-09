<?php

namespace App\Infrastructure\Container;

use App\ExternalApi\ApiClient\ShopApiHttpClient;
use App\ExternalApi\Products\DataProvider\ApiProductMapper;
use App\ExternalApi\Products\DataProvider\ProductApiHttpClientInterface;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\Infrastructure\CommandHandler\CommandHandler;
use App\Infrastructure\ServiceProviders\ApiProductsServiceProvider;
use App\Infrastructure\ServiceProviders\CommandBusServiceProvider;
use App\Infrastructure\ServiceProviders\CommandsServiceProvider;
use App\Infrastructure\ServiceProviders\ModuleCustomersServiceProvider;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use League\Container\Argument\Literal\StringArgument;
use League\Container\Container;
use League\Container\DefinitionContainerInterface;
use League\Tactician\CommandBus;

class ContainerFactory
{
    private const string CONTAINER_COMMAND_HANDLER_KEY = 'command_handler';

    public static function create(): DefinitionContainerInterface
    {
        $container = new Container();

        $container
            ->addServiceProvider(new PathProvider())
            ->addServiceProvider(new ConfigurationProvider())
            ->addServiceProvider(new ApiProductsServiceProvider())
            ->addServiceProvider(new CommandsServiceProvider())
            ->addServiceProvider(new CommandBusServiceProvider())
            ->addServiceProvider(new ModuleCustomersServiceProvider());

        $container
            ->add(self::CONTAINER_COMMAND_HANDLER_KEY, CommandHandler::class)
            ->addArgument(CommandBus::class);

        return $container;
    }
}
