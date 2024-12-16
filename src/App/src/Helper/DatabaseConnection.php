<?php

declare(strict_types=1);

namespace App\Helper;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Хелпер - устанавливает конект для БД
 */
class DatabaseConnection
{
    /**
     * Инициализирует базу данных
     *
     * @return void void
     */
    public static function initializeDatabase(): void
    {
        $connection = [
            'driver'    => $_ENV['DRIVER'],
            'host'      => $_ENV['MYSQL_HOST'],
            'database'  => $_ENV['MYSQL_DATABASE'],
            'username'  => $_ENV['MYSQL_USER'],
            'password'  => $_ENV['MYSQL_PASSWORD'],
            'charset'   => $_ENV['CHARSET'],
            'collation' => $_ENV['COLLATION'],
            'prefix'    => '',
        ];

        $capsule = new Capsule();
        $capsule->addConnection($connection);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
