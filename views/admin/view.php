<?php
/*
 * Страница просмотра товара
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Просмотр товара: '  . $model->product_name ;
?>
<?php if (isset($errorMsg)): ?>
    <?php echo Alert::widget([
        'options' => [
            'class' => 'alert-info',
        ],
        'body' => $errorMsg,
    ]);
    ?>
<?php endif ?>

<h1><?= Html::encode($this->title); ?></h1>
<p>
    <?= Html::a('Изменить', ['update', 'id' => $model->product_id], ['class' => 'btn btn-primary']); ?>
    <?= Html::a(
            'Удалить',
            ['delete', 'id' => $model->product_id],
            ['class' => 'btn btn-danger', 'data' => ['method' => 'post']]
        );?>
</p>

<?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'slug',
            [
                'label' => 'Цена',
                'attribute' => 'price'
            ],
            [
                'label' => 'Валюта',
                'attribute' => 'currency'
            ],
            [
                'label' => 'Статус активности',
                'attribute' => 'activity_status'
            ],
        ],
    ]);
?>