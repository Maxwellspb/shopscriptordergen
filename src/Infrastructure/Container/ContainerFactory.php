<?php

namespace App\Infrastructure\Container;

use App\Infrastructure\CommandHandler\ServiceProvider\CommandHandlingServiceProvider;
use League\Container\Container;
use Psr\Container\ContainerInterface;

class ContainerFactory
{
    public static function create(): ContainerInterface
    {
        $container = new Container();

        $container->addServiceProvider(new CommandHandlingServiceProvider());

        return $container;
    }
}