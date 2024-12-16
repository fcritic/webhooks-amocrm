<?php

declare(strict_types=1);

namespace Sync\Console\Producer;

use JsonException;
use Pheanstalk\Pheanstalk;
use Psr\Http\Message\ServerRequestInterface;
use Sync\config\BeanstalkConfig;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class WebhookQueueProducer
{
    /** @var Pheanstalk|null Коннект с сервером очередей */
    private ?Pheanstalk $connection;

    /** @var string Просматриваемая очередь */
    private string $queue = 'webhooks';

    /** Конструктор WebhookQueueProducer */
    public function __construct(BeanstalkConfig $beanstalk)
    {
        $this->connection = $beanstalk->getConnection();
    }

    /**
     * Продюсер вызывается в хендлере и отправляет задачи в только в указанную очередь.
     *
     * @throws JsonException
     */
    public function produce(array $data): void
    {
        $this->connection
            ->useTube($this->queue)
            ->put(json_encode($data, JSON_THROW_ON_ERROR));
    }
}
