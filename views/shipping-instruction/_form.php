<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use kartik\widgets\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use app\models\CompanyProfile;
use app\models\ContainerPort;
use app\models\ShippingInstruction;

/**
 * @var yii\web\View $this
 * @var app\models\ShippingInstruction $model
 * @var yii\widgets\ActiveForm $form
 */
$formname = $model->formName();
?>

<style>

    #select2-shippinginstructionform-shipper_id-results li, #select2-shippinginstructionform-shipper_id-container {
        text-transform: uppercase;
    }

    .uppercase {
        text-transform: uppercase;
    }

</style>

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

        <div>

            <!-- attribute number -->
            <?=
                $form
                ->field($model, 'number')
                ->textInput()
                ->widget(
                    MaskedInput::className(),
                    [
                    'mask' => ShippingInstruction::NUMBERMASK,
                    'options' => [
                        'class' => 'form-control uppercase',
                        'maxlength' => 12,
                    ],
                    'clientOptions' => [
                        'greedy' => false,
                        'removeMaskOnSubmit' => false,
                    ],
                    ]
            );
            ?>

            <!-- petunjuk format nomor SI -->
            <div class="form-group">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Petunjuk</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <p>4 digit angka, spasi, 2 digit kode,spasi, 3 digit kota.</p>
                            <p>Contoh : 0001 EE SRG</p>
                            <p>
                                <b>EE</b> : Emkl Ekspor<br/>
                                <b>EI</b> : Emkl Impor<br/>
                                <b>JPR</b> : Jepara<br/>
                                <b>SLO</b> : Solo<br/>
                                <b>SRG</b> : Semarang<br/>
                                <b>YGY</b> : Yogyakarta<br/>
                            </p>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

            </div>

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
                        'minimumInputLength' => 1,
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

            <div id="input-shipperdetail">

                <?=
                    $form
                    ->field($model, 'shipperAddress')
                    ->textarea(['rows' => 3])
                    ->hint('<i class="greynote">*sesuai yang tertera di NPWP</i>')
                ?>

                <?= $form->field($model, 'shipperPhone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'shipperEmail')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'shipperNpwp')->textInput(['maxlength' => true]) ?>

            </div>

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
                        'minimumInputLength' => 1,
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
                if (($destination = ContainerPort::findOne($model->destination_id)) !== null) {
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

        </div>

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

<?php
$js = <<<JS

	$(function() {

        $('#shippinginstructionform-number').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#shippinginstructionform-shipper_id').select2('open');
                event.preventDefault();
            }
        });

        $('#shippinginstructionform-shipper_id').on('select2:open', function (event) {
            $('.select2-search__field').addClass('uppercase');
        });

        $('#shippinginstructionform-shipper_id').on('select2:close', function (event) {
            shipper = $(this).val();

            if (shipper && isNaN(shipper)) {
                $('#input-shipperdetail').show({
                    effect: 'blind',
                    complete: function(){
                        $('#shippinginstructionform-shipperaddress').focus();
                    }
                });
            } else {
                $('#input-shipperdetail').hide({
                    effect: 'blind',
                    complete: function(){
                        setTimeout(function() {
                            shipper = $('#shippinginstructionform-shipper_id').val();

                            if (shipper) {
                                $('#shippinginstructionform-shipping_id').select2('open');
                            }
                        }, 300);
                    }
                });
            }
        });

        $('#shippinginstructionform-shipperphone').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#shippinginstructionform-shipperemail').focus();
                event.preventDefault();
            }
        });

        $('#shippinginstructionform-shipperemail').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#shippinginstructionform-shippernpwp').focus();
                event.preventDefault();
            }
        });

        $('#shippinginstructionform-shippernpwp').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#shippinginstructionform-shipping_id').select2('open');
                event.preventDefault();
            }
        });

        $('#shippinginstructionform-shipping_id').on('select2:close', function (event) {
            setTimeout(function() {
                shipping = $('#shippinginstructionform-shipping_id').val();

                if (shipping) {
                    $('#shippinginstructionform-destination_id').select2('open');
                } else {
                    $('#shippinginstructionform-destination_id').select2('close');
                }
            }, 300);
        });

        // trigger
    
        $('#input-shipperdetail').hide();
        $('#shippinginstructionform-number').focus();

	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

