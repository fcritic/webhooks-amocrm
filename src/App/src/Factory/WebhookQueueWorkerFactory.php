<?php

declare(strict_types=1);

namespace App\Factory;

use App\config\BeanstalkConfig;
use App\Console\Workers\WebhookQueueWorker;
use App\Entity\ErrorEntity;
use App\Entity\WebhookEntity;
use App\Helper\DatabaseConnection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class WebhookQueueWorkerFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): WebhookQueueWorker
    {
        DatabaseConnection::initializeDatabase();
        $beanstalk     = $container->get(BeanstalkConfig::class);
        $webhookEntity = $container->get(WebhookEntity::class);
        $errorEntity   = $container->get(ErrorEntity::class);

        return new WebhookQueueWorker($beanstalk, $webhookEntity, $errorEntity);
    }
}
