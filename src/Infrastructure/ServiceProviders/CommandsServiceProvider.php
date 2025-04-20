<?php

namespace App\Infrastructure\ServiceProviders;

use App\ExternalApi\Customers\DataProvider\CustomersApi;
use App\ExternalApi\Orders\DataProvider\OrdersApi;
use App\ExternalApi\Products\DataProvider\ProductsApi;
use App\Module\Common\Service\Generator\AmountGenerator;
use App\Module\Customers\Application\AddApiCustomersCommand;
use App\Module\Customers\Application\AddApiCustomersCommandHandler;
use App\Module\Customers\Application\ListApiCustomersQuery;
use App\Module\Customers\Application\ListApiCustomersQueryHandler;
use App\Module\Customers\Domain\Customer\DataProvider\ApiCustomersProviderInterface;
use App\Module\Customers\Domain\Customer\DataProvider\CustomersDataProviderInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorInterface;
use App\Module\Customers\Domain\Customer\Service\CustomersGeneratorService;
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
        AddApiCustomersCommand::class => AddApiCustomersCommandHandler::class,
        ListApiCustomersQuery::class => ListApiCustomersQueryHandler::class,
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
            ->add(AddApiCustomersCommandHandler::class)
            ->addArguments(
                [
                    CustomersDataProviderInterface::class,
                    CustomersGeneratorService::class
                ]
            );

        $container
            ->add(ListApiCustomersQueryHandler::class)
            ->addArgument(ApiCustomersProviderInterface::class);

        $container
            ->add(AddApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);

        $container
            ->add(CompleteApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);

        $container
            ->add(MassGenerateOrdersCommandHandler::class)
            ->addArguments([
                CustomersDataProviderInterface::class,
                CustomersGeneratorService::class,
                AmountGenerator::class,
                AmountGenerator::class,
            ]);

        $container
            ->add(RefundApiOrderCommandHandler::class)
            ->addArgument(OrdersApi::class);
    }
}
