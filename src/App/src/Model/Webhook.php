<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель
 *
 * @property int    $id
 * @property int    $account_id
 * @property string $chat_id
 * @property string $talk_id
 * @property string $author_id
 * @property string $message
 * @property string $webhook
 * @property string $headers
 */
class Webhook extends Model
{
    /**
     * Таблица, связанная с моделью
     *
     * @var string
     */
    protected $table = 'webhook';

    /** @var string */
    protected $primaryKey = 'id';

    /**
     * Указывает, должна ли модель иметь временную метку
     *
     * @var bool
     */
    public $timestamps = true;

    /** @var string[] */
    protected $fillable = [
        'id',
        'account_id',
        'chat_id',
        'talk_id',
        'author_id',
        'message',
        'webhook',
        'headers',
    ];
}
