<?php

declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;
use Dale08\Fibonacci\Http\Controllers\Home;
use Dale08\Fibonacci\Http\Controllers\Fibonacci;
use Psr\Container\ContainerInterface;
use Dale08\Fibonacci\Services\Generator;
use Dale08\Fibonacci\Services\FibonacciGenerator;
use Dale08\Fibonacci\Services\Cache\FibonacciCached;

const PROJECT_DIR = __DIR__;

require PROJECT_DIR . '/vendor/autoload.php';

// Create Container using PHP-DI
$container = new Container();
// Set container to create App with on AppFactory
AppFactory::setContainer($container);
// Instantiate App
$app = AppFactory::create();
//$container = new DI\Container();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes
$app->get('/', Home::class);

$container->set(Generator::class, function () {
    return new FibonacciGenerator();
});
$container->set(FibonacciCached::class, function (ContainerInterface $container) {
    return new FibonacciCached(
        new Predis\Client([
            'host' => 'redis'
        ]),
        $container->get(Generator::class)
    );
});
$container->set(Fibonacci::class, function (ContainerInterface $container) {
    return new Fibonacci($container->get(FibonacciCached::class));
});
$app->get('/fibonacci', Fibonacci::class);

$app->run();