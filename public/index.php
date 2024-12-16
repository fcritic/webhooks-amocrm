<?php

declare(strict_types=1);

// Delegate static file requests back to the PHP built-in webserver
use App\Helper\ConfigLoader;
use App\Helper\DatabaseConnection;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

ConfigLoader::loadEnv();
DatabaseConnection::initializeDatabase();

/**
 * Self-called anonymous function that creates its own scope and keeps the global namespace clean.
 */
(static function () {
    /** @var ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var Application $app */
    $app     = $container->get(Application::class);
    $factory = $container->get(MiddlewareFactory::class);

    // Execute programmatic/declarative middleware pipeline and routing
    // configuration statements
    (require 'config/pipeline.php')($app, $factory, $container);
    (require 'config/routes.php')($app, $factory, $container);

    $app->run();
})();
