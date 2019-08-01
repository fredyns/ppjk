<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var app\models\search\ProfileSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="profile-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'public_email') ?>

    <?= $form->field($model, 'gravatar_email') ?>

    <?= $form->field($model, 'gravatar_id') ?>

    <?php // echo $form->field($model, 'location')?>

    <?php // echo $form->field($model, 'website')?>

    <?php // echo $form->field($model, 'bio')?>

    <?php // echo $form->field($model, 'timezone')?>

    <?php // echo $form->field($model, 'picture_id')?>

    <?php // echo $form->field($model, 'phone')?>

    <?php // echo $form->field($model, 'address')?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
