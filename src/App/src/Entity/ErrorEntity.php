<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\Error;
use Illuminate\Database\Eloquent\Model;

class ErrorEntity extends AbstractEntity
{
    /** @var Error */
    protected Model $model;

    /**
     * Конструктор класса
     */
    public function __construct()
    {
        parent::__construct(new Error());
    }

    public function addError(string $request, string $headers): Model
    {
        $data = [
            'request' => $request,
            'headers' => $headers,
        ];

        return $this->add($data);
    }
}
