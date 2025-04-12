<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\Module\Customers\Application\AddExternalCustomersCommand;
use App\Module\Customers\Application\AddExternalCustomersCommandHandler;
use App\Module\Customers\Application\ListExternalCustomersQuery;
use App\Module\Customers\Application\ListExternalCustomersQueryHandler;
use App\Module\Customers\Domain\Customer\DataProvider\ExternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\DataProvider\InternalCustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorInterface;
use App\Module\Order\Application\AddApiOrderCommand;
use App\Module\Order\Application\AddApiOrderCommandHandler;
use App\Module\Order\Application\CompleteApiOrderCommand;
use App\Module\Order\Application\CompleteApiOrderCommandHandler;
use App\Module\Order\Application\MassGenerateOrdersCommand;
use App\Module\Order\Application\MassGenerateOrdersCommandHandler;
use App\Module\Order\Application\RefundApiOrderCommand;
use App\Module\Order\Application\RefundApiOrderCommandHandler;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class CommandsServiceProvider extends AbstractServiceProvider
{
    public const string CONTAINER_MAP_KEY = 'command_handler_map';

    private array $commandHandlerMap = [
        AddExternalCustomersCommand::class => AddExternalCustomersCommandHandler::class,
        ListExternalCustomersQuery::class => ListExternalCustomersQueryHandler::class,
        AddApiOrderCommand::class => AddApiOrderCommandHandler::class,
        CompleteApiOrderCommand::class => CompleteApiOrderCommandHandler::class,
        MassGenerateOrdersCommand::class => MassGenerateOrdersCommandHandler::class,
        RefundApiOrderCommand::class => RefundApiOrderCommandHandler::class,
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

        $container
            ->add(AddApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);

        $container
            ->add(CompleteApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);

        $container
            ->add(MassGenerateOrdersCommandHandler::class)
            ->addArguments([
                CustomersApi::class,
                OrdersApi::class,
                ProductsApi::class,
            ]);

        $container
            ->add(RefundApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);
    }
}
