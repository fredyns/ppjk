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

        <br/>

        <!-- attribute picture -->

        <?php if (!empty($model->picture_id)): ?>

            <div class="col-sm-6 col-sm-offset-3">
                <p>
                    <?=
                    Html::img(
                        ['/file', 'id' => $model->picture_id],
                        [
                        'class' => 'img-responsive',
                        'alt' => 'picture',
                        ]
                    )
                    ?>
                </p>
            </div>
            <div class="clearfix"></div>

        <?php endif; ?>

        <p>

            <?= $form->field($model, 'picture')->label('Picture')->fileInput(); ?>

            <!-- attribute name -->
            <?=
            $form->field($model, 'name')->textInput(['maxlength' => true])
            ?>

            <!-- attribute phone -->
            <?=
            $form->field($model, 'phone')->textInput(['maxlength' => true])
            ?>

            <!-- attribute public_email -->
            <?=
            $form->field($model, 'public_email')->textInput(['maxlength' => true])
            ?>

            <!-- attribute address -->
            <?=
            $form->field($model, 'address')->textarea(['rows' => 6])
            ?>

            <!-- attribute bio -->
            <?=
            $form->field($model, 'bio')->textarea(['rows' => 6])
            ?>

            <!-- attribute website -->
            <?=
            $form->field($model, 'website')->textInput(['maxlength' => true])
            ?>

            <!-- attribute timezone -->
            <?=
                $form
                ->field($model, 'timezone')
                ->dropDownList(
                    \yii\helpers\ArrayHelper::map(
                        \dektrium\user\helpers\Timezone::getAll(), 'timezone', 'name'
                    )
            );
            ?>

        </p>

        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Profile'),
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

