<?php

namespace App\Infrastructure\CommandHandler;

use App\Module\Order\Application\MassGenerateOrdersCommand;
use League\Tactician\CommandBus;

class CommandHandler
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function handle(array $args): void
    {
        $this->commandBus->handle(new MassGenerateOrdersCommand());
    }
}
