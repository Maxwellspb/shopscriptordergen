<?php

namespace App\Infrastructure\ServiceProviders;

use App\Module\Customers\Application\AddExternalCustomersCommand;
use App\Module\Customers\Application\AddExternalCustomersCommandHandler;
use App\Module\Customers\Application\ListExternalCustomersQuery;
use App\Module\Customers\Application\ListExternalCustomersQueryHandler;
use App\Module\Customers\Domain\DataProvider\ExternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\DataProvider\InternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Service\CustomersGeneratorInterface;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CommandsServiceProvider extends AbstractServiceProvider
{
    public const string CONTAINER_MAP_KEY = 'command_handler_map';

    private array $commandHandlerMap = [
        AddExternalCustomersCommand::class => AddExternalCustomersCommandHandler::class,
        ListExternalCustomersQuery::class => ListExternalCustomersQueryHandler::class,
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
            ->add(AddExternalCustomersCommandHandler::class)
            ->addArguments(
                [
                    InternalCustomersDataProviderInterface::class,
                    CustomersGeneratorInterface::class
                ]
            );

        $container
            ->add(ListExternalCustomersQueryHandler::class)
            ->addArgument(ExternalCustomersDataProviderInterface::class);
    }
}
