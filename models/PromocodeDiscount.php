<?php

namespace app\models;

use yii\base\Model;

/**
 * Класс для работы с промокодами
 *
 * @author Просветов Владислав
 * @version 1.0, 19.03.2021
 */
class PromocodeDiscount extends Model
{

    /** Тип скидки: рубли */
    const TYPE_DISCOUNT_RUBLE = 'ruble';
    /** Тип скидки: Проценты */
    const TYPE_DISCOUNT_PERCENT = 'percent';

    /**
     * Пересчитывает цену товаров с учетом скидки
     *
     * @author Просветов Владислав
     * @version 1.0, 22.03.2021
     *
     * @param Promocodes $PromoDiscount Объект скидки
     * @param array $products Массив с товарами
     * @return array
     */
    public static function recalculatePrice (Promocodes $PromoDiscount, array $products): array
    {
        foreach ($products as &$product) {
            if (in_array($product['id'], json_decode($PromoDiscount->product_id))) {
                if ($PromoDiscount->type_discount === self::TYPE_DISCOUNT_RUBLE) {
                    $product['priceBeforeDiscount'] = $product['price'];
                    if ($product['price'] > $PromoDiscount->discount) {
                        $product['price'] = $product['price'] - $PromoDiscount->discount;
                        $product['discount'] = $PromoDiscount->discount . 'руб.';
                    } else {
                        $product['discount'] = $product['price'] . 'руб.';
                        $product['price'] =  0;
                    }
                } else if ($PromoDiscount->type_discount === self::TYPE_DISCOUNT_PERCENT) {
                    $product['priceBeforeDiscount'] = $product['price'];
                    $product['price'] = $product['price'] * (100 - $PromoDiscount->discount);
                    $product['discount'] = $PromoDiscount->discount . '%';
                }
            }
        }
        return $products;
    }

    /**
     * Применяет промокод
     *
     * @author Просветов Владислав
     * @version 1.0, 25.03.2021
     *
     * @param string $promocode Прокомод
     * @param array $products Массив с товарами
     * @return array
     */
    public static function activatePromocode(string $promocode, array $products): array
    {
        $PromoDiscount = Promocodes::findOne(['promocode' => $promocode]);
        return self::recalculatePrice($PromoDiscount,$products);
    }
}