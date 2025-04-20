<?php

namespace App\Infrastructure\Container;

use App\Infrastructure\CommandHandler\CommandHandler;
use App\Infrastructure\ServiceProviders\ApiCustomersServiceProvider;
use App\Infrastructure\ServiceProviders\ApiOrdersServiceProvider;
use App\Infrastructure\ServiceProviders\ApiProductsServiceProvider;
use App\Infrastructure\ServiceProviders\ApplicationServiceProvider;
use App\Infrastructure\ServiceProviders\CommandBusServiceProvider;
use App\Infrastructure\ServiceProviders\CommandsServiceProvider;
use App\Infrastructure\ServiceProviders\CommonServicesProvider;
use App\Infrastructure\ServiceProviders\ModuleCustomersServiceProvider;
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
            ->addServiceProvider(new CommonServicesProvider())
            ->addServiceProvider(new ApplicationServiceProvider())
            ->addServiceProvider(new ApiProductsServiceProvider())
            ->addServiceProvider(new ApiCustomersServiceProvider())
            ->addServiceProvider(new ApiOrdersServiceProvider())
            ->addServiceProvider(new ModuleCustomersServiceProvider())
            ->addServiceProvider(new CommandsServiceProvider())
            ->addServiceProvider(new CommandBusServiceProvider());

        $container
            ->add(self::CONTAINER_COMMAND_HANDLER_KEY, CommandHandler::class)
            ->addArgument(CommandBus::class);

        return $container;
    }
}
