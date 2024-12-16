<?php

declare(strict_types=1);

namespace App\Entity;

use App\Interface\EntityInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Базовый абстрактный класс сущности для наследования
 */
abstract class AbstractEntity implements EntityInterface
{
    protected Model $model;

    /**
     * Конструктор класса
     *
     * @param Model $model Модель
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Получения сущности из БД, необходимо передавать
     * поле по которому происходит поиск и значение которое ищется
     *
     * @param string $field Поле
     * @param string $value Значение
     * @return Model|null   Сущность?
     */
    public function getBy(string $field, string $value): Model|null
    {
        return $this->model->where($field, $value)?->first();
    }

    /**
     * Метод отвечающий за добавления сущности в БД
     *
     * @param array $data Данный сущности
     * @return Model модель
     */
    public function add(array $data): Model
    {
        $model = new $this->model();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    /**
     * Редактирование сущности в БД
     *
     * @param array $data           Данные для обновления
     * @param Model $existingRecord Имеющаяся сущность в БД
     */
    public function update(array $data, Model $existingRecord): void
    {
        foreach ($data as $key => $value) {
            $existingRecord->$key = $value;
        }
        $existingRecord->save();
    }
}
