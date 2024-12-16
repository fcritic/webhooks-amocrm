<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Webhook;
use Illuminate\Database\Eloquent\Model;

/**
 * Сущность для токена
 */
class WebhookEntity extends AbstractEntity
{
    /** @var Webhook */
    protected Model $model;

    /**
     * Конструктор класса
     */
    public function __construct()
    {
        parent::__construct(new Webhook());
    }

    public function addWebhook(array $webhook, string $jsonWebhook, string $headers): Model
    {
        $data = [
            'account_id' => $webhook['account']['id'],
            'chat_id'    => $webhook['message']['add'][0]['chat_id'],
            'talk_id'    => $webhook['message']['add'][0]['talk_id'],
            'author_id'  => $webhook['message']['add'][0]['author']['id'],
            'message'    => $webhook['message']['add'][0]['text'],
            'webhook'    => $jsonWebhook,
            'headers'    => $headers,
        ];

        return $this->add($data);
    }
}
