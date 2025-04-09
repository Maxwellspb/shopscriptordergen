<?php

namespace App\Infrastructure\ServiceProviders;

use App\Module\Customers\Application\AddCustomersCommand;
use App\Module\Customers\Application\AddCustomersCommandHandler;
use App\Module\Customers\Domain\Service\CustomerDataProviderInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CommandsServiceProvider extends AbstractServiceProvider
{
    public const string CONTAINER_MAP_KEY = 'command_handler_map';

    private array $commandHandlerMap = [
        AddCustomersCommand::class => AddCustomersCommandHandler::class
    ];

    public function provides(string $id): bool
    {
        return $id === self::CONTAINER_MAP_KEY || in_array($id, array_values($this->commandHandlerMap));
    }

    public function register(): void
    {
        $container = $this->getContainer();

        $container->add(self::CONTAINER_MAP_KEY, new ArrayArgument($this->commandHandlerMap));

        $container
            ->add(AddCustomersCommandHandler::class)
            ->addArgument(CustomerDataProviderInterface::class);
    }
}
