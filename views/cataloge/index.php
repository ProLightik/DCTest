<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<h1>Каталог</h1>
<div>
    <?php if (!$promocode):?>
        <?= Html::beginForm(['index'], 'post', ['class' => 'form-inline']); ?>
            <?= Html::input('text', 'promocode', Yii::$app->request->post('string'), ['class' => 'form-control']) ?>
            <?= Html::submitButton('Жмяк', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    <?php else: ?>
        <div>
            <?= Html::beginForm(); ?>
                <b style="margin: 20px"><?= $promocode ?></b>
                <?= Html::a('Отменить', ['index', 'class' => 'btn btn-sm', 'id' => 'deactivatePromocode']) ?>
            <?= Html::endForm() ?>
        </div>
    <?php endif ?>
</div>
<div>
    <table>
        <tr>
            <td style="width: 150px">Наименование</td>
            <td style="width: 150px">Slug</td>
            <td style="width: 150px">Цена</td>
            <td style="width: 150px">Валюта</td>
            <td style="width: 150px"> Скидка </td>
            <td style="width: 150px">Оригинальная валюта</td>
            <td style="width: 150px">Оригинальная цена</td>
        </tr>
        <?php foreach ($products as $product):?>
            <tr>
                <td> <?= Html::a(Html::encode("{$product['name']}"), ['admin/view', 'id' => $product['id']]) ?> </td>
                <td> <?= Html::encode("{$product['slug']}") ?> </td>
                <td>
                    <?= isset($product['priceBeforeDiscount'])
                        ? Html::encode($product['price']) . ' ' . '<strike>' . Html::encode($product['priceBeforeDiscount']) . '</strike>'
                        : Html::encode($product['price'])
                    ?>
                </td>
                <td> <?= Html::encode("{$product['currency']}") ?> </td>
                <td> <?= isset($product['discount']) ? Html::encode("{$product['discount']}") : '' ?> </td>
                <td> <?= isset($product['originalCurrency']) ? Html::encode("{$product['originalCurrency']}") : '' ?> </td>
                <td> <?= isset($product['originalPrice']) ? Html::encode("{$product['originalPrice']}") : '' ?> </td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<?= LinkPager::widget(['pagination' => $pagination]) ?>