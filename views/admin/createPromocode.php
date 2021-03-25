<?php
/*
 * Страница добавления нового промокода, файл modules/admin/views/createPromocode.php
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Product */

$this->title = 'Новый промокод';
?>

    <h1><?= Html::encode($this->title); ?></h1>
<?=
$this->render(
    '_promocodeForm',
    [
        'model' => $model,
        'products' => $products,
        'message' => $message
    ]
);
?>