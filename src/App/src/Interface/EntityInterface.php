<?php

declare(strict_types=1);

namespace App\Interface;

use Illuminate\Database\Eloquent\Model;

/**
 * Интерфейс для наследования абстрактной сущности
 */
interface EntityInterface
{
    /**
     * Добавляет
     *
     * @param array $data Данные
     * @return Model      Сущность
     */
    public function add(array $data): Model;

    /**
     * Получает
     *
     * @param string $field       Поле
     * @param string $value       Значение
     * @return Model|array|null   Модель?
     */
    public function getBy(string $field, string $value): Model|array|null;

    /**
     * Изменяет
     *
     * @param array $data           Данные
     * @param Model $existingRecord Имеющиеся данные
     * @return void                 void
     */
    public function update(array $data, Model $existingRecord): void;
}
