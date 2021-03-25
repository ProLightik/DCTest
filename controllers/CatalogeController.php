<?php

namespace app\controllers;

use app\models\CurrencyCourse;
use app\models\Products;
use app\models\Promocodes;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\web\Controller;
use Yii;
use yii\web\Cookie;
use app\models\PromocodeDiscount;

/**
 * Класс для работы со страницей Каталога от лица пользователя
 */
class CatalogeController extends Controller
{

    /**
     * Действие страницы каталога
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $cookies = Yii::$app->response->cookies;
        $query = Products::find();
        $count = $query
            ->where(['activity_status' => '1'])
            ->count();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);
        $products = $query->orderBy('product_id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->where(['activity_status' => 1])
            ->all();
        $promocode = '';
        $message = '';

        if (Yii::$app->request->post('promocode')) {
            if (Promocodes::findOne(['promocode' => Yii::$app->request->post('promocode')])) {
                $cookies->add( new Cookie([
                    'name' => 'promocode',
                    'value' => Yii::$app->request->post('promocode'),
                ]));
            }
        }

        if ($cookies->getValue('promocode') || (Yii::$app->request->cookies)->getValue('promocode')) {
            $promocode = $cookies->getValue('promocode')
                        ? $cookies->getValue('promocode')
                        : (Yii::$app->request->cookies)->getValue('promocode');
        }

        if (Yii::$app->request->get('id') == 'deactivatePromocode') {
            $cookies->remove('promocode');
            $promocode = '';
        }

        $products = self::convertCurrency($products);
        if ($promocode) {
            $products = PromocodeDiscount::activatePromocode($promocode, $products);
        }

        return $this->render('index', [
            'products' => $products,
            'pagination' => $pagination,
            'promocode' => $promocode,
            'message' => $message,
        ]);
    }

    /**
     * Конвертирует валюту товара в рубли
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param array|ActiveRecord
     * @return array
     */
    public static function convertCurrency($products): array
    {
        $query = CurrencyCourse::find();
        $currencyCourses = $query->all();

        $convertedProducts = [];
        foreach ($products as $product) {
            $productData = [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'slug' => $product->slug,
                'currency' => 'RUB',
                'price' => $product->price
            ];
            foreach ($currencyCourses as $currencyCourse) {
                if ($currencyCourse->currency_name == $product->currency) {
                    $productData['originalPrice'] = $product->price;
                    $productData['originalCurrency'] = $product->currency;
                    $productData['price'] = round($product->price * $currencyCourse->currency_in_ruble, 2);
                }
            }
            $convertedProducts[] = $productData;
        }
        return $convertedProducts;
    }
}