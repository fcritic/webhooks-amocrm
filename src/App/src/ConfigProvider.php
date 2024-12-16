<?php

declare(strict_types=1);

namespace App;

use App\Factory\AmoWebHookHandlerFactory;
use App\Handler\AmoWebHookHandler;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    /** Returns the container dependencies */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                AmoWebHookHandler::class => AmoWebHookHandlerFactory::class,
            ],
        ];
    }
}
