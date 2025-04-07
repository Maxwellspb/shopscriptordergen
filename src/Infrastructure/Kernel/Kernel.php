<?php

namespace App\Infrastructure\Kernel;

use League\Container\ContainerAwareInterface;
use League\Container\DefinitionContainerInterface;

class Kernel implements ContainerAwareInterface
{
    private DefinitionContainerInterface $container;

    public function getContainer(): DefinitionContainerInterface
    {
        return $this->container;
    }

    public function setContainer(DefinitionContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }

    public function handleCommand(array $arguments): void
    {
        if ($this->container->has('command_handler')) {
            $commandHandler = $this->container->get('command_handler');

            $commandHandler->handle($arguments);
        }
    }
}
