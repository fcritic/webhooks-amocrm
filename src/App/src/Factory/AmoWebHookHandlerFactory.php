<?php

declare(strict_types=1);

namespace App\Factory;

use App\Console\Producer\WebhookQueueProducer;
use App\Handler\AmoWebHookHandler;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use RuntimeException;

class AmoWebHookHandlerFactory
{
    /**
     * @param ContainerInterface $container container
     * @return AmoWebHookHandler Handler
     */
    public function __invoke(ContainerInterface $container): AmoWebHookHandler
    {
        try {
            $producer = $container->get(WebhookQueueProducer::class);
        } catch (ContainerExceptionInterface $e) {
            throw new RuntimeException($e->getMessage());
        }

        return new AmoWebHookHandler($producer);
    }
}
