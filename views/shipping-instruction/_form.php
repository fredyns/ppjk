<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var app\models\ShippingInstruction $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="shipping-instruction-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'ShippingInstruction',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);
    
    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <!-- attribute number -->
            <?=
            $form->field($model, 'number')->textInput()
            ?>

            <!-- attribute shipper_id -->
            <?=
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
            $form->field($model, 'shipper_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\CompanyProfile::find()->all(), 'id', 'name'),
                [
                    'prompt' => 'Select',
                    'disabled' => (isset($relAttributes) && isset($relAttributes['shipper_id'])),
                ]
            );
            ?>

            <!-- attribute shipping_id -->
            <?=
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
            $form->field($model, 'shipping_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Shipping::find()->all(), 'id', 'name'),
                [
                    'prompt' => 'Select',
                    'disabled' => (isset($relAttributes) && isset($relAttributes['shipping_id'])),
                ]
            );
            ?>

            <!-- attribute destination_id -->
            <?=
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
            $form->field($model, 'destination_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\ContainerPort::find()->all(), 'id', 'name'),
                [
                    'prompt' => 'Select',
                    'disabled' => (isset($relAttributes) && isset($relAttributes['destination_id'])),
                ]
            );
            ?>
        </p>

        <?php $this->endBlock(); ?>
        
        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label'   => Yii::t('app', 'ShippingInstruction'),
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

