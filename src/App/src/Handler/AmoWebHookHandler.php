<?php

declare(strict_types=1);

namespace App\Handler;

use App\Entity\ErrorEntity;
use Exception;
use JsonException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sync\Console\Producer\WebhookQueueProducer;

use function json_encode;

use const JSON_THROW_ON_ERROR;

class AmoWebHookHandler implements RequestHandlerInterface
{
    /** @var WebhookQueueProducer продюсер для передачи хуков в очередь */
    protected WebhookQueueProducer $producer;

    /** Конструктор хендлера */
    public function __construct(WebhookQueueProducer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * Получаем хук и парсим его на тело и заголовки
     *
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): JsonResponse
    {
        $data = [
            'webhook' => $request->getParsedBody(),
            'headers' => json_encode($request->getHeaders(), JSON_THROW_ON_ERROR),
        ];

        try {
            $this->producer->produce($data);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        return new JsonResponse([
            'success' => true,
        ]);
    }
}
