<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\ShippingInstructionSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="shipping-instruction-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'shipper_id') ?>

    <?= $form->field($model, 'shipping_id') ?>

    <?= $form->field($model, 'destination_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
