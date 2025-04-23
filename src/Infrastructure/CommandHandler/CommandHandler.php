<?php

namespace App\Infrastructure\CommandHandler;

use App\Module\Orders\Application\MassGenerateOrdersCommand;
use League\Tactician\CommandBus;

class CommandHandler
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function handle(array $args): void
    {
        //$this->commandBus->handle(new AddApiCustomersCommand());
        //$this->commandBus->handle(new AddApiOrderCommand());
        //$this->commandBus->handle(new CompleteApiOrderCommand(795));
        //$this->commandBus->handle(new RefundApiOrderCommand(795));
        $this->commandBus->handle(new MassGenerateOrdersCommand());
    }
}
