<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Shipping $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="shipping-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Shipping',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);
    
    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <!-- attribute name -->
            <?=
            $form->field($model, 'name')->textInput(['maxlength' => true])
            ?>
        </p>

        <?php $this->endBlock(); ?>
        
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label'   => Yii::t('app', 'Shipping'),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ],
        ]);
        ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?=
        Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
            ]
        );
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

