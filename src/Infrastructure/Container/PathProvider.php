<?php

namespace App\Infrastructure\Container;

use League\Container\Argument\Literal\StringArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class PathProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    public function boot(): void
    {
        $container = $this->getContainer();

        $paths = require getcwd() . '/config/paths.php';

        foreach ($paths as $alias => $value) {
            $container->add($alias, new StringArgument($value));
        }
    }

    public function provides(string $id): bool
    {
        return false;
    }

    public function register(): void
    {
        // TODO: Implement register() method.
    }
}