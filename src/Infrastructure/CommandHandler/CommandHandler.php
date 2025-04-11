<?php

namespace App\Infrastructure\CommandHandler;

use App\Module\Customers\Application\AddExternalCustomersCommand;
use App\Module\Customers\Application\ListExternalCustomersQuery;
use App\Module\Order\Application\AddApiOrderCommand;
use App\Module\Order\Application\CompleteApiOrderCommand;
use League\Tactician\CommandBus;

class CommandHandler
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function handle(array $args): void
    {
        $this->commandBus->handle(new CompleteApiOrderCommand(22));
    }
}
