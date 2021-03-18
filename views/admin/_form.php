<?php
/*
 * Форма для добавления и редактирования товара, файл modules/admin/views/product/_form.php
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'product_name')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'slug')->textInput(); ?>
<?= $form->field($model, 'price')->textInput(['maxlength' => true]); ?>
<?= $form->field($model, 'currency')->dropDownList([
        'RUB' => 'Рубли',
        'USD' => 'Доллары',
        'EUR' => 'Евро'
]); ?>
<?php if($model->formName() != 'CreateForm'): ?>
<?= $form->field($model, 'activity_status')->textInput(); ?>
<?php endif ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>