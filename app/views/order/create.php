<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/** @var yii\web\View $this */
/** @var app\models\OrderForm $model */
/** @var app\models\Product[] $products */

$form = ActiveForm::begin();
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'status')->dropDownList(\app\models\Order::optsStatus()) ?>

<h3>Товары</h3>
<div id="order-items">
    <?php foreach ($model->items as $i => $item): ?>
        <div class="order-item">
            <?= Html::dropDownList("OrderForm[items][$i][product_id]", $item['product_id'] ?? null,
                ArrayHelper::map($products, 'id', 'name'),
                ['class' => 'form-control', 'prompt' => 'Выберите товар']
            ) ?>
            <?= Html::textInput("OrderForm[items][$i][count]", $item['count'] ?? 1, ['class' => 'form-control', 'type' => 'number', 'min' => 1]) ?>
            <?= Html::textInput("OrderForm[items][$i][price]", $item['price'] ?? null, ['class' => 'form-control', 'type' => 'number', 'step' => '0.01']) ?>
        </div>
    <?php endforeach; ?>
</div>

<div>
    <button type="button" id="add-item" class="btn btn-secondary">+ Добавить товар</button>
</div>

<div class="form-group mt-3">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php

$productsNames = json_encode(ArrayHelper::map($products, 'id', 'name'));
$productsPrices = json_encode(ArrayHelper::map($products, 'id', 'price'));
$js = <<<JS
let products = $productsNames;
let prices = $productsPrices;
let itemIndex = 0;

function createOrderItem(index) {
    let html = '<div class="order-item mb-2">';
    html += '<select name="OrderForm[items]['+index+'][product_id]" class="form-control mb-1">';
    html += '<option value="">Выберите товар</option>';
    for (const id in products) {
        html += '<option value="'+id+'">'+products[id]+' - '+prices[id]+'</option>';
    }
    html += '</select>';
    html += '<input type="number" name="OrderForm[items]['+index+'][count]" value="1" min="1" class="form-control mb-1" placeholder="Количество" />';
    html += '<button type="button" class="btn btn-danger remove-item">Удалить</button>';
    html += '</div>';
    return html;
}

$('#add-item').on('click', function() {
    $('#order-items').append(createOrderItem(itemIndex));
    itemIndex++;
});

// Удаление товара
$('#order-items').on('click', '.remove-item', function() {
    $(this).closest('.order-item').remove();
});
JS;

$this->registerJs($js);
?>


