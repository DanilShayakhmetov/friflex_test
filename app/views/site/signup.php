<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var app\models\SignUpForm $model */

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="signup-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'options' => ['class' => 'form-horizontal'],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
