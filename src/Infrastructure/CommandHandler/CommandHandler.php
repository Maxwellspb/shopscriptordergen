<?php

namespace App\Infrastructure\CommandHandler;

use App\Module\Order\Application\AddApiOrderCommand;
use App\Module\Order\Application\CompleteApiOrderCommand;
use App\Module\Order\Application\MassGenerateOrdersCommand;
use App\Module\Order\Application\RefundApiOrderCommand;
use League\Tactician\CommandBus;

class CommandHandler
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function handle(array $args): void
    {
        //$this->commandBus->handle(new AddApiOrderCommand());
        //$this->commandBus->handle(new CompleteApiOrderCommand(795));
        //$this->commandBus->handle(new RefundApiOrderCommand(795));
        $this->commandBus->handle(new MassGenerateOrdersCommand());
    }
}
