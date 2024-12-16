<?php

declare(strict_types=1);

namespace Sync\Factory;

use App\Entity\ErrorEntity;
use App\Entity\WebhookEntity;
use App\Helper\DatabaseConnection;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sync\config\BeanstalkConfig;
use Sync\Console\Workers\WebhookQueueWorker;

class WebhookQueueWorkerFactory
{
    /**
     * Фабрика для воркера. Отдает сущности для их создания в БД и конфиг для работы с очередями
     *
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
