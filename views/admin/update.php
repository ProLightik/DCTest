<?php
/*
 * Страница редактирования товара, файл modules/admin/views/product/update.php
 */
use yii\helpers\Html;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Products */

$this->title = 'Редактирование товара: ' . $model->product_name;
?>

<h1><?= Html::encode($this->title); ?></h1>
<?php if ($errorMsg): ?>
    <?php echo Alert::widget([
        'options' => [
            'class' => 'alert-info',
        ],
        'body' => $errorMsg,
    ]);
    ?>
<?php endif ?>
<?=
$this->render(
    '_form',
    ['model' => $model]
);
?>