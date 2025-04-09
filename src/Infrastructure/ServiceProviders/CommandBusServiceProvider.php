<?php

namespace App\Infrastructure\ServiceProviders;

use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Container\ContainerLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use League\Tactician\Handler\MethodNameInflector\InvokeInflector;

class CommandBusServiceProvider extends AbstractServiceProvider
{
    public function provides(string $id): bool
    {
        return $id === CommandBus::class;
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $containerLocator = new ContainerLocator(
            $container,
            $container->get(CommandsServiceProvider::CONTAINER_MAP_KEY),
        );

        $commandHandlerMiddleware = new CommandHandlerMiddleware(
            new ClassNameExtractor(),
            $containerLocator,
            new InvokeInflector()
        );

        $commandBus = new CommandBus(
            [
                $commandHandlerMiddleware,
            ]
        );

        $container->add(CommandBus::class, $commandBus);
    }
}
