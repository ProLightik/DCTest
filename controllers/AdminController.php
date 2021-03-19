<?php

namespace app\controllers;

use app\models\CreateForm;
use app\models\Products;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use app\models\EntryForm;
use yii\helpers\Inflector;
use yii\web\Response;
use yii\web\NotFoundHttpException;

/**
 * Класс для функционала Администратора
 *
 * @author Просветов Владислав
 * @version 1.0, 19.03.2021
 */
class AdminController extends Controller
{

    /**
     * Действие каталога за Администратора
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new EntryForm();
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

        $products = CatalogeController::convertCurrency($products);

        return $this->render('index', [
            'products' => $products,
            'pagination' => $pagination,
            'model' => $model,
        ]);
    }

    /**
     * Действие просмотра товара
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param int $id Идентификатор товара
     * @return string
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Действие создания нового товара
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new CreateForm();
        $newProduct = new Products();
        if ($newProduct->load(Yii::$app->request->post(), 'CreateForm')) {
            if ($newProduct->slug) {
                if (Products::findOne(['slug' => $newProduct->slug])) {
                    $newProduct->slug = $this->getSlug($newProduct->product_name);
                 }
            } else {
                $newProduct->slug = $this->getSlug($newProduct->product_name);
            }
            if ($newProduct->save()) {
                return $this->redirect([
                        'view',
                        'id' => $newProduct->product_id]
                );
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Действие обновления товара
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param int $id Идентификатор товара
     * @return Response|string
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);
        $errorMsg = '';

        if ($model->load(Yii::$app->request->post())) {
            if ($model->activity_status == 1 && !$model->price) {
                $errorMsg = 'Нельзя убрать цену у активного товара';
            } else {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->product_id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'errorMsg' => $errorMsg,
        ]);
    }

    /**
     * Действие удаление товара
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param int $id Идентификатор товара
     * @return Response|string
     */
    public function actionDelete(int $id): Response|string
    {
        $model = $this->findModel($id);
        if ($model->activity_status == 1) {
            $errorMsg = 'Нельзя удалить активный товар';
            return $this->render('view', [
                'model' => $model,
                'errorMsg' => $errorMsg,
            ]);
        } else {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Действие страницы черновиков
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @return string
     */
    public function actionDrafts(): string
    {

        $errorMessage = '';
        if (isset(Yii::$app->request->get()['id'])) {
            $product = $this->findModel(Yii::$app->request->get()['id']);
            if (!$product->price) {
                $errorMessage = 'Для активации товара нужно указать цену';
            } else {
                $product->updateAttributes(['activity_status' => '1']);
            }

        }

        $query = Products::find();
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $query->count(),
        ]);

        $model = $query->orderBy('product_id ASC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->where(['activity_status' => 2])
            ->all();
        $model = CatalogeController::convertCurrency($model);
        return $this->render('drafts', [
            'model' => $model,
            'pagination' => $pagination,
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Действие активации товара
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param int $id Идентификатор товара
     * @return string
     */
    public function actionActivate(int $id): string
    {
        $model = $this->findModel($id);
        $model->updateAttributes(['activity_status' => '1']);
        return $this->redirect(['view', 'id' => $model->product_id]);
    }

    /**
     * Возвращает ответ в формате JSON
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @return Response
     */
    public function actionGetJson() {
        $query = Products::find();
        $products = $query->orderBy('product_id ASC')
            ->where(['activity_status' => 1])
            ->all();

        $products = CatalogeController::convertCurrency($products);

        return $this->asJson($products);
    }

    /**
     * Ищет товар по идентификатору
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param int $id Идентификатор товара
     * @throws NotFoundHttpException
     * @return string
     */
    public function findModel(int $id): string
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Генерирует уникальный Slug(использует рекурсию)
     *
     * @author Просветов Владислав
     * @version 1.0, 19.03.2021
     *
     * @param string $name Наименование товара
     * @param int $number Число, которое будет дополнительно конкантенироваться
     * @return string
     */
    public function getSlug(string $name, int $number = 1): string
    {
     $slug = Inflector::slug(Inflector::transliterate($name)) . $number;
        if (Products::findOne(['slug' => $slug])) {
            return $this->getSlug($name, ++$number);
        }

        return $slug;
    }
}