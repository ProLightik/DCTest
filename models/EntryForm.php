<?php

namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $slug;
    public $price;
    public $currency;
    public $originalCurrency;
    public $originalPrice;

    public function actionTest()
    {
        var_dump(1);
    }

}