<?php

declare(strict_types=1);

namespace App\Helper;

use JsonException;

use function json_decode;

use const JSON_THROW_ON_ERROR;

class ValidatorWebHook
{
    /** @var string  */
    protected const TYPE_WEBHOOK = 'message';

    /**
     * @throws JsonException
     */
    public static function isValid(string $headers, array $webhook): bool
    {
        $headersArray = json_decode($headers, true, 512, JSON_THROW_ON_ERROR);

        return $headersArray['content-type'][0] === 'application/x-www-form-urlencoded' &&
            isset($webhook[self::TYPE_WEBHOOK]);
    }
}
