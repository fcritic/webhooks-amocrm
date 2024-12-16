<?php

declare(strict_types=1);

use App\Helper\ConfigLoader;

ConfigLoader::loadEnv();

return [
    'database' => [
        'driver'    => $_ENV['DRIVER'],
        'username'  => $_ENV['MYSQL_USER'] ?: '',
        'password'  => $_ENV['MYSQL_PASSWORD'] ?: '',
        'host'      => $_ENV['MYSQL_HOST'] ?: '',
        'database'  => $_ENV['MYSQL_DATABASE'] ?: '',
        'port'      => $_ENV['MYSQL_PORT'] ?: 3306,
        'charset'   => $_ENV['CHARSET'] ?: 'utf8',
        'collation' => $_ENV['COLLATION'] ?: 'utf8_unicode_ci',
        'prefix'    => '',
    ],
];
