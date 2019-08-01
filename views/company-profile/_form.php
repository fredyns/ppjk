<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use app\models\CompanyType;

/**
 * @var yii\web\View $this
 * @var app\models\CompanyProfile $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="company-profile-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'CompanyProfile',
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

            <!-- attribute companyType_id -->
            <?=
            $form->field($model, 'companyType_id')->dropDownList(CompanyType::options())
            ?>

            <!-- attribute address -->
            <?=
            $form->field($model, 'address')->textarea(['rows' => 6])
            ?>

            <!-- attribute phone -->
            <?=
            $form->field($model, 'phone')->textInput(['maxlength' => true])
            ?>

            <!-- attribute email -->
            <?=
            $form->field($model, 'email')->textInput(['maxlength' => true])
            ?>

            <!-- attribute npwp -->
            <?=
            $form->field($model, 'npwp')->textInput(['maxlength' => true])
            ?>

        </p>

        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Company Profile'),
                    'content' => $this->blocks['main'],
                    'active' => true,
                ],
            ],
        ]);
        ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?=
        Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> '.
            ($model->isNewRecord ? 'Create' : 'Save'),
            [
            'id' => 'save-'.$model->formName(),
            'class' => 'btn btn-success'
            ]
        );
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

