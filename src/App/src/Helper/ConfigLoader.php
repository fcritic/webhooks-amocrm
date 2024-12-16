<?php

declare(strict_types=1);

namespace App\Helper;

use RuntimeException;
use Symfony\Component\Dotenv\Dotenv;

use function file_exists;

/**
 * Хелпер - загружает данные в ENV
 */
class ConfigLoader
{
    /**
     * Настройка данных в ENV
     */
    public static function loadEnv(): void
    {
        $envPath = '.env';

        if (file_exists($envPath)) {
            $dotenv = new Dotenv();
            $dotenv->load($envPath);
        } else {
            throw new RuntimeException('Файл .env не найден');
        }
    }
}
