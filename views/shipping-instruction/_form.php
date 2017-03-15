<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use kartik\widgets\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use app\models\CompanyProfile;

/**
 * @var yii\web\View $this
 * @var app\models\ShippingInstruction $model
 * @var yii\widgets\ActiveForm $form
 */
$formname = $model->formName();
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
            <?php
            $shipperLabel = $model->shipper_id;

            if ($model->shipper_id > 0) {
                if (($shipper = CompanyProfile::findOne($model->shipper_id)) !== null) {
                    $shipperLabel = $shipper->name;
                }
            }

            echo $form
                ->field($model, 'shipper_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => $shipperLabel,
                    'options' => ['placeholder' => 'mencari perusahaan ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['/api/company-profile/list-shipper']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(item) { return item.text; }'),
                        'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                    ],
            ]);
            ?>

            <?=
                $form
                ->field($model, 'shipperAddress')
                ->textarea(['rows' => 3])
                ->hint('<i class="greynote">*sesuai yang tertera di NPWP</i>')
            ?>

            <?= $form->field($model, 'shipperNpwp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipperPhone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'shipperEmail')->textInput(['maxlength' => true]) ?>

            <!-- attribute shipping_id -->
            <?php
            $shippingLabel = $model->shipping_id;

            if ($model->shipping_id > 0) {
                if (($shipping = CompanyProfile::findOne($model->shipping_id)) !== null) {
                    $shippingLabel = $shipping->name;
                }
            }

            echo $form
                ->field($model, 'shipping_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => $shippingLabel,
                    'options' => ['placeholder' => 'mencari pelayaran ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['/api/company-profile/list-shipping']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(item) { return item.text; }'),
                        'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                    ],
            ]);
            ?>

            <!-- attribute destination_id -->
            <?php
            $destinationLabel = $model->destination_id;

            if ($model->destination_id > 0) {
                if (($destination = TruckSupervisor::findOne($model->destination_id)) !== null) {
                    $destinationLabel = $destination->name;
                }
            }

            echo $form
                ->field($model, 'destination_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => $destinationLabel,
                    'options' => ['placeholder' => 'mencari pelabuhan ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                        ],
                        'ajax' => [
                            'url' => Url::to(['/api/container-port/list']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(item) { return item.text; }'),
                        'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                    ],
            ]);
            ?>

        </p>

        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Shipping Instruction'),
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

<script>

    function shipper_check()
    {
        shipperInput = $('#<?= $formname ?>-shipper_id').val();

        if (shipperInput && isNaN(shipperInput))
        {
            shipperDetail_show();
        } else
        {
            shipperDetail_hide();
        }
    }

    function shipperDetail_show()
    {
        $('.field-<?= $formname ?>-shipperaddress').show('blind');
        $('.field-<?= $formname ?>-shippernpwp').show('blind');
        $('.field-<?= $formname ?>-shipperphone').show('blind');
        $('.field-<?= $formname ?>-shipperemail').show('blind');
    }

    function shipperDetail_hide()
    {
        $('.field-<?= $formname ?>-shipperaddress').hide('blind');
        $('.field-<?= $formname ?>-shippernpwp').hide('blind');
        $('.field-<?= $formname ?>-shipperphone').hide('blind');
        $('.field-<?= $formname ?>-shipperemail').hide('blind');
    }

</script>

<?php
$js = <<<JS

	$(function () {
        $('.field-{$formname}-shipperaddress').hide();
        $('.field-{$formname}-shippernpwp').hide();
        $('.field-{$formname}-shipperphone').hide();
        $('.field-{$formname}-shipperemail').hide();

        $('select').on('select2:select', function (evt) {
            shipper_check();
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

