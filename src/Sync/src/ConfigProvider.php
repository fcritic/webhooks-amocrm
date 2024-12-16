<?php

declare(strict_types=1);

namespace Sync;

use App\Entity\ErrorEntity;
use App\Entity\WebhookEntity;
use Psr\Container\ContainerInterface;
use Sync\config\BeanstalkConfig;
use Sync\Console\Command\WebhookQueueWorkerCommand;
use Sync\Console\Producer\WebhookQueueProducer;
use Sync\Console\Workers\WebhookQueueWorker;
use Sync\Factory\WebhookQueueWorkerFactory;

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
            'laminas-cli'  => $this->getCliConfig(),
        ];
    }

    /** Returns the container dependencies */
    public function getDependencies(): array
    {
        return [
            'invokables' => [],
            'factories'  => [
                WebhookQueueWorker::class        => WebhookQueueWorkerFactory::class,
                WebhookEntity::class             => function () {
                    return new WebhookEntity();
                },
                ErrorEntity::class               => function () {
                    return new ErrorEntity();
                },
                BeanstalkConfig::class           => function (ContainerInterface $container) {
                    return new BeanstalkConfig($container);
                },
                WebhookQueueProducer::class      => function (ContainerInterface $container) {
                    return new WebhookQueueProducer($container->get(BeanstalkConfig::class));
                },
                WebhookQueueWorkerCommand::class => function (ContainerInterface $container) {
                    return new WebhookQueueWorkerCommand($container);
                },
            ],
        ];
    }

    /** return cli-commands list */
    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'app:webhook-queue-worker' => WebhookQueueWorkerCommand::class,
            ],
        ];
    }
}
