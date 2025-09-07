<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Order $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(Yii::$app->user->identity->isRoleAdmin()): ?>

        <?= $form->field($model, 'user_id')->textInput() ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'date')->textInput() ?>

        <?= $form->field($model, 'status')->dropDownList(\app\models\Order::optsStatus()) ?>

        <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'created_at')->textInput() ?>
    <?php elseif (Yii::$app->user->identity->isRoleManager()): ?>

        <?= $form->field($model, 'user_id')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'date')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'total_price')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'created_at')->textInput(['readonly' => true]) ?>

        <?= $form->field($model, 'status')->dropDownList(\app\models\Order::optsStatus()) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
