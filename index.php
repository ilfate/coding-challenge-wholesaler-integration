<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('di.php');
$container = $builder->build();
$application = $container->get(\kollex\Application\Application::class);

$application->run();
