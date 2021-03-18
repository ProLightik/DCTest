<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<h1>Admin-Каталог</h1>
<div style="margin: 10px 10px 10px 0;">
    <?= Html::a('Создать товар', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('Черновики', ['drafts'], ['class' => 'btn btn-info']) ?>
</div>
    <table>
        <tr>
            <td style="width: 150px">Наименование</td>
            <td style="width: 150px">Slug</td>
            <td style="width: 150px">Цена</td>
            <td style="width: 150px">Валюта</td>
            <td style="width: 150px">Оригинальная валюта</td>
            <td style="width: 150px">Оригинальная цена</td>
        </tr>
        <?php foreach ($products as $product):?>
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
            </tr>
        <?php endforeach ?>
    </table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>

