<?php

declare(strict_types=1);

namespace App\Handler;

use App\Console\Producer\WebhookQueueProducer;
use App\Entity\ErrorEntity;
use Exception;
use JsonException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class AmoWebHookHandler implements RequestHandlerInterface
{
    protected WebhookQueueProducer $producer;
    protected ErrorEntity $error;

    public function __construct(WebhookQueueProducer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): JsonResponse
    {
        $webhook = $request->getParsedBody();
        $headers = json_encode($request->getHeaders(), JSON_THROW_ON_ERROR);

        try {
            $this->producer->produce($webhook, $headers);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 200);
        }

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
