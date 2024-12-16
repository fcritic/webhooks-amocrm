<?php

declare(strict_types=1);

namespace Sync\Helper;

use JsonException;

use function json_decode;

use const JSON_THROW_ON_ERROR;

class ValidatorWebHook
{
    /**
     * @var string хук с amoCRM имеет в себе массив.
     * В случае на входящие сообщения это ``message``
     */
    protected const TYPE_WEBHOOK = 'message';

    /**
     * Валидирует по заголовку который всегда отдает amoCRM и по типу событию которое указано в TYPE_WEBHOOK
     *
     * @throws JsonException
     */
    public static function isValid(string $headers, array $webhook): bool
    {
        $headersArray = json_decode($headers, true, 512, JSON_THROW_ON_ERROR);

        return $headersArray['content-type'][0] === 'application/x-www-form-urlencoded' &&
            isset($webhook[self::TYPE_WEBHOOK]);
    }
}
