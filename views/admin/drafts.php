<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
?>

<?php if ($errorMessage): ?>
    <?php echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $errorMessage,
        ]);
    ?>
<?php endif ?>

<h1>Admin-Каталог</h1>
<table>
    <tr>
        <td style="width: 150px">Наименование</td>
        <td style="width: 150px">Slug</td>
        <td style="width: 150px">Цена</td>
        <td style="width: 150px">Валюта</td>
        <td style="width: 150px">Оригинальная валюта</td>
        <td style="width: 150px">Оригинальная цена</td>
    </tr>
    <?php foreach ($model as $product):?>
        <tr>
            <td> <?= Html::a(Html::encode("{$product['name']}"), ['view', 'id' => $product['id']]) ?> </td>
            <td> <?= Html::encode("{$product['slug']}") ?> </td>
            <td> <?= Html::encode("{$product['price']}") ?> </td>
            <td> <?= Html::encode("{$product['currency']}") ?> </td>
            <?php if(isset($product['originalCurrency'])): ?>
                <td> <?= Html::encode("{$product['originalCurrency']}") ?> </td>
                <td> <?= Html::encode("{$product['originalPrice']}") ?> </td>
            <?php else: ?>
                <td></td>
                <td></td>
            <?php endif ?>
            <td> <?= Html::a(Html::encode('Активировать'), ['drafts', 'id' => $product['id']]) ?> </td>
        </tr>
    <?php endforeach ?>
</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>