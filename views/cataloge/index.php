<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<h1>Каталог</h1>
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
        <td> <?= Html::encode("{$product['name']}") ?> </td>
        <td> <?= Html::encode("{$product['slug']}") ?> </td>
        <td> <?= Html::encode("{$product['price']}") ?> </td>
        <td> <?= Html::encode("{$product['currency']}") ?> </td>
        <?php if(isset($product['originalCurrency'])): ?>
            <td> <?= Html::encode("{$product['originalCurrency']}") ?> </td>
            <td> <?= Html::encode("{$product['originalPrice']}") ?> </td>
        <?php endif ?>
    </tr>
    <?php endforeach ?>
</table>

<?= LinkPager::widget(['pagination' => $pagination]) ?>