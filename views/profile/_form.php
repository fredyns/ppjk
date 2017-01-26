<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\Profile $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="profile-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'Profile',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);
    
    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <!-- attribute bio -->
            <?=
            $form->field($model, 'bio')->textarea(['rows' => 6])
            ?>

            <!-- attribute timezone -->
            <?=
            $form->field($model, 'timezone')->textInput(['maxlength' => true])
            ?>

            <!-- attribute public_email -->
            <?=
            $form->field($model, 'public_email')->textInput(['maxlength' => true])
            ?>

            <!-- attribute gravatar_email -->
            <?=
            $form->field($model, 'gravatar_email')->textInput(['maxlength' => true])
            ?>

            <!-- attribute website -->
            <?=
            $form->field($model, 'website')->textInput(['maxlength' => true])
            ?>

            <!-- attribute name -->
            <?=
            $form->field($model, 'name')->textInput(['maxlength' => true])
            ?>

            <!-- attribute location -->
            <?=
            $form->field($model, 'location')->textInput(['maxlength' => true])
            ?>

            <!-- attribute picture -->
        </p>

        <?php $this->endBlock(); ?>
        
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label'   => Yii::t('app', 'Profile'),
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

