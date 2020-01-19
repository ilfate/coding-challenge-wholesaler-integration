<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$container = new DI\Container();

$application = $container->get(\kollex\Application\Application::class);

$application->run();
