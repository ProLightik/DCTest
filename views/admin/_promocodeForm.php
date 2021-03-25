<?php
/*
 * Форма для добавления нового промокода, файл modules/admin/views/_promocodeForm.php
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use yii\bootstrap\Alert;
?>

<?php if ($message): ?>
    <?php echo Alert::widget([
        'options' => [
            'class' => 'alert-info',
        ],
        'body' => $message,
    ]);
    ?>
<?php endif ?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'promocode')->textInput(['maxlength' => true]); ?>
    <?= $form->field($model, 'discount')->textInput(); ?>
    <?= $form->field($model, 'type_discount')->dropDownList([
        'ruble' => 'Рубли',
        'percent' => 'Проценты',
    ]); ?>

    <?= $form->field($model, 'product_id')->checkboxList(ArrayHelper::map($products, 'product_id', 'product_name')); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>