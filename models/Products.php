<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Класс для работы с таблицей товаров
 * @package app\models
 */
class Products extends ActiveRecord
{

    /**
     * Правила валидации полей формы при создании и редактировании товара
     */
    public function rules() {
        return [
            [['product_name'],'required'],
            [['product_id', 'activity_status'], 'integer'],
            [['product_name', 'currency', 'slug'], 'string'],
            [['price'], 'number'],
        ];
    }

    /**
     * Возвращает имена полей формы для создания и редактирования товара
     */
    public function attributeLabels() {
        return [
            'product_id' => 'ID',
            'product_name' => 'Наименование',
            'slug' => 'SLUG',
            'price' => 'Цена',
            'currency' => 'Валюта',
            'activity_status' => 'Статус активности',
        ];
    }
}