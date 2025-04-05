<?php

namespace App\Infrastructure\CommandHandler;

interface CommandHandlerInterface
{
    public function handle(array $args): void;
}
