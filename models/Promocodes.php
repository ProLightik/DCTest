<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Класс для работы с таблицей промокодов
 * @package app\models
 */
class Promocodes extends ActiveRecord
{

    /**
     * Правила валидации полей формы при создании промокода
     */
    public function rules() {
        return [
            [['promocode', 'discount', 'type_discount', 'product_id'],'required'],
            [['discount'], 'integer'],
            [['promocode'], 'string'],
        ];
    }

    /**
     * Возвращает имена полей формы промокода
     */
    public function attributeLabels() {
        return [
            'idpromocodes' => 'ID',
            'promocode' => 'Промокод',
            'discount' => 'Скидка',
            'type_discount' => 'Тип скидки',
            'product_id' => 'Товары для скидки',
        ];
    }
}