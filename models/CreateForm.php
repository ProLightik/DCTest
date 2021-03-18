<?php
namespace app\models;

use yii\base\Model;

class CreateForm extends Model
{

    public $product_name;
    public $slug;
    public $price;
    public $currency;

    public function rules() {
        return [
            [['product_name'], 'required', 'message' => 'Это поле обязательно для заполнения'],
            [['product_id'], 'integer'],
            [['product_name', 'currency', 'slug'], 'string'],
            [['price'], 'number'],
        ];
    }

    public function attributeLabels() {
        return [
            'product_name' => 'Название товара',
            'slug' => 'SLUG',
            'price' => 'Цена',
            'currency' => 'Валюта',
        ];
    }
}