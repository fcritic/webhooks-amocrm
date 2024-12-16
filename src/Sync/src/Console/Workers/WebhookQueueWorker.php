<?php

declare(strict_types=1);

namespace App\Console\Workers;

use App\config\BeanstalkConfig;
use App\Entity\ErrorEntity;
use App\Entity\WebhookEntity;
use App\Helper\ValidatorWebHook;
use Exception;
use JsonException;
use Symfony\Component\Console\Output\OutputInterface;

use function date;
use function json_encode;

use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

class WebhookQueueWorker extends AbstractWorker
{
    protected string $queue = 'webhooks';
    private WebhookEntity $webhook;
    private ErrorEntity $error;

    public function __construct(BeanstalkConfig $beanstalk, WebhookEntity $webhook, ErrorEntity $error)
    {
        parent::__construct($beanstalk);
        $this->webhook = $webhook;
        $this->error   = $error;
    }

    /**
     * @throws JsonException
     */
    public function process(mixed $data, OutputInterface $output): void
    {
        $webhook = $data['webhook'];
        $headers = $data['headers'];

        try {
            $output->writeln('Processing webhook: ' . date("Y-m-d H:i:s"));

            if (ValidatorWebHook::isValid($headers, $webhook)) {
                $modelWebhook = $this->webhook
                    ->addWebhook(
                        $webhook,
                        json_encode($webhook, JSON_THROW_ON_ERROR),
                        $headers
                    );
                $output->writeln('Webhook processed ' . $modelWebhook->id . PHP_EOL);
            } else {
                $modelError = $this->error->addError(json_encode($webhook, JSON_THROW_ON_ERROR), $headers);
                $output->writeln(
                    'Error: Invalid data received, skipping...'
                    . PHP_EOL
                    . 'ID error: '
                    . $modelError->id
                    . PHP_EOL
                );
            }
        } catch (Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
            throw new JsonException($e->getMessage());
        }
    }
}
