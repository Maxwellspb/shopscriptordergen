<?php

use App\Infrastructure\Container\ContainerFactory;
use App\Infrastructure\Kernel\Kernel;

require_once "vendor/autoload.php";

$container = ContainerFactory::create();
$kernel = (new Kernel())->setContainer($container);
$kernel->handleCommand($argv);