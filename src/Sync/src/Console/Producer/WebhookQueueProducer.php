<?php

declare(strict_types=1);

namespace App\Console\Producer;

use App\config\BeanstalkConfig;
use JsonException;
use Pheanstalk\Pheanstalk;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class WebhookQueueProducer
{
    private Pheanstalk $connection;
    private string $queue = 'webhooks';

    public function __construct(BeanstalkConfig $beanstalk)
    {
        $this->connection = $beanstalk->getConnection();
    }

    /**
     * @throws JsonException
     */
    public function produce(array $webhook, string $headers): void
    {
        $data = [
            'webhook' => $webhook,
            'headers' => $headers,
        ];

        $this->connection
            ->useTube($this->queue)
            ->put(json_encode($data, JSON_THROW_ON_ERROR));
    }
}
