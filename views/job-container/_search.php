<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\JobContainerSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="job-container-search">

    <?php
    $form = ActiveForm::begin([
            'action' => ['index'],
            'layout' => 'horizontal',
            'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'shippingInstruction_id') ?>

    <?= $form->field($model, 'containerNumber') ?>

    <?= $form->field($model, 'sealNumber') ?>

    <?= $form->field($model, 'stuffingDate') ?>

    <?= $form->field($model, 'stuffingLocation_id') ?>

    <?php // echo $form->field($model, 'driver_id')?>

    <?php // echo $form->field($model, 'supervisor_id')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
