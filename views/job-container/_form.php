<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use kartik\widgets\Select2;
use app\models\form\JobContainerForm;
use app\models\CompanyProfile;
use app\models\ContainerType;
use app\models\ContainerPort;
use app\models\JobContainer;
use app\models\StuffingLocation;
use app\models\TruckSupervisor;

/* @var $this \yii\web\View $this */
/* @var $model \app\models\JobContainer  */
/* @var $form \yii\widgets\ActiveForm  */
?>

<style>
    #jobcontainerform-newsi .radio {
        float: left;
        margin-right: 10px;
    }

    .uppercase {
        text-transform: uppercase;
    }

</style>

<div class="job-container-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'JobContainerForm',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);

    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    echo Html::hiddenInput('nextAction', 'done', ['id' => 'nextAction']);
    ?>

    <div class="">

        <?php $this->beginBlock('ShippingInstruction'); ?>

        <div id="input-si">

            <!-- attribute newSi -->
            <?=
                $form
                ->field($model, 'newSi')
                ->label('New SI')
                ->radioList(JobContainerForm::optsNewSi(), ['itemOptions' => ['class' => 'newsi-opts']]);
            ?>

            <div id="input-picksi">

                <!-- attribute shippingInstruction_id -->
                <?=
                    $form
                    ->field($model, 'shippingInstruction_id')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => ArrayHelper::getValue($model, 'shippingInstruction.number'),
                        'options' => [
                            'placeholder' => 'mencari shipping instruction ...',
                        ],
                        'pluginOptions' => [
                            'minimumInputLength' => 2,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['/api/shipping-instruction/list']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(itemData) { return itemData.text; }'),
                            'templateSelection' => new JsExpression('function (itemData) { return itemData.text; }'),
                        ],
                ]);
                ?>

            </div>

            <div id="input-newsi">

                <!-- attribute shippingInstructionNumber -->
                <?=
                    $form
                    ->field($model, 'shippingInstructionNumber')
                    ->textInput([
                        'class' => 'form-control uppercase',
                        'maxlength' => true,
                ]);
                ?>

                <div id="input-shipper">

                    <!-- attribute shipperId -->
                    <?php
                    $shipperLabel = $model->shipperId;

                    if ($model->shipperId > 0) {
                        if (($shipper = CompanyProfile::findOne($model->shipperId)) !== null) {
                            $shipperLabel = $shipper->name;
                        }
                    }

                    echo $form
                        ->field($model, 'shipperId')
                        ->label('Shipper Name')
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

                        <!-- attribute shipperAddress -->
                        <?=
                        $form->field($model, 'shipperAddress')->textarea(['rows' => 3])
                        ?>

                        <!-- attribute shipperPhone -->
                        <?=
                        $form->field($model, 'shipperPhone')->textInput(['maxlength' => true])
                        ?>

                        <!-- attribute shipperEmail -->
                        <?=
                        $form->field($model, 'shipperEmail')->textInput(['maxlength' => true])
                        ?>

                        <!-- attribute shipperNpwp -->
                        <?=
                        $form->field($model, 'shipperNpwp')->textInput(['maxlength' => true])
                        ?>

                    </div>

                </div>

                <!-- attribute shippingId -->
                <?php
                $shippingLabel = $model->shippingId;

                if ($model->shippingId > 0) {
                    if (($shipping = CompanyProfile::findOne($model->shippingId)) !== null) {
                        $shippingLabel = $shipping->name;
                    }
                }

                echo $form
                    ->field($model, 'shippingId')
                    ->label('Shipping Name')
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

                <!-- attribute destinationId -->
                <?php
                $destinationLabel = $model->destinationId;

                if ($model->destinationId > 0) {
                    if (($destination = ContainerPort::findOne($model->destinationId)) !== null) {
                        $destinationLabel = $destination->name;
                    }
                }

                echo $form
                    ->field($model, 'destinationId')
                    ->label('Destination Name')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => $destinationLabel,
                        'options' => ['placeholder' => 'mencari pelabuhan ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                            'minimumInputLength' => 1,
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

        </div>

        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('main'); ?>

        <!-- attribute containerNumber -->
        <?=
            $form
            ->field($model, 'containerNumber')
            ->textInput()
            ->widget(
                MaskedInput::className(),
                [
                'mask' => JobContainer::CONTAINERNUMBERMASK,
                'options' => [
                    'class' => 'form-control uppercase',
                    'maxlength' => 11,
                ],
                ]
        );
        ?>

        <!-- attribute size -->
        <?=
        $form->field($model, 'size')->dropDownList(JobContainerForm::optsSize())
        ?>

        <!-- attribute type_id -->
        <?=
        $form->field($model, 'type_id')->dropDownList(ContainerType::options())
        ?>

        <!-- attribute sealNumber -->
        <?=
            $form
            ->field($model, 'sealNumber')
            ->textInput([
                'class' => 'form-control uppercase',
                'maxlength' => 11,
            ])
        ?>

        <!-- attribute stuffingDate -->
        <?=
            $form
            ->field($model, 'stuffingDate')
            ->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
        ]);
        ?>

        <!-- attribute containerDepoId -->
        <?php
        $containerDepoLabel = $model->containerDepo_id;

        if ($model->containerDepo_id > 0) {
            if (($containerDepo = CompanyProfile::findOne($model->containerDepo_id)) !== null) {
                $containerDepoLabel = $containerDepo->name;
            }
        }

        echo $form
            ->field($model, 'containerDepo_id')
            ->widget(Select2::classname(),
                [
                'initValueText' => $containerDepoLabel,
                'options' => ['placeholder' => 'mencari perusahaan ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/company-profile/list-depo']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
        ]);
        ?>

        <!-- attribute stuffingLocation_id -->
        <?php
        $locationLabel = $model->stuffingLocation_id;

        if ($model->stuffingLocation_id > 0) {
            if (($location = StuffingLocation::findOne($model->stuffingLocation_id)) !== null) {
                $locationLabel = $location->name;
            }
        }

        echo $form
            ->field($model, 'stuffingLocation_id')
            ->widget(Select2::classname(),
                [
                'initValueText' => $locationLabel,
                'options' => ['placeholder' => 'mencari lokasi stuffing ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/stuffing-location/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
        ]);
        ?>

        <!-- attribute supervisor_id -->
        <?php
        $supervisorLabel = $model->supervisor_id;

        if ($model->supervisor_id > 0) {
            if (($supervisor = TruckSupervisor::findOne($model->supervisor_id)) !== null) {
                $supervisorLabel = $supervisor->name;
            }
        }

        echo $form
            ->field($model, 'supervisor_id')
            ->widget(Select2::classname(),
                [
                'initValueText' => $supervisorLabel,
                'options' => ['placeholder' => 'mencari mandor ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/truck-supervisor/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
        ]);
        ?>

        <!-- attribute truckVendor_id -->
        <?php
        $truckVendorLabel = $model->truckVendor_id;

        if ($model->truckVendor_id > 0) {
            if (($truckVendor = CompanyProfile::findOne($model->truckVendor_id)) !== null) {
                $truckVendorLabel = $truckVendor->name;
            }
        }

        echo $form
            ->field($model, 'truckVendor_id')
            ->widget(Select2::classname(),
                [
                'initValueText' => $truckVendorLabel,
                'options' => ['placeholder' => 'mencari perusahaan ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 1,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/company-profile/list-truck-vendor']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
        ]);
        ?>

        <!-- attribute driverName -->
        <?=
        $form->field($model, 'driverName')->textInput(['maxlength' => true])
        ?>

        <!-- attribute cellphone -->
        <?=
        $form->field($model, 'cellphone')->textInput(['maxlength' => true])
        ?>

        <!-- attribute policenumber -->
        <?=
        $form->field($model, 'policenumber')->textInput([
            'class' => 'form-control uppercase',
            'maxlength' => 11,
        ])
        ?>

        <!-- attribute notes -->
        <?=
        $form->field($model, 'notes')->textarea(['rows' => 6])
        ?>

        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Shipping Instruction'),
                    'content' => $this->blocks['ShippingInstruction'],
                    'active' => true,
                ],
            ],
        ]);
        ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Job Container'),
                    'content' => $this->blocks['main'],
                    'active' => true,
                ],
            ],
        ]);
        ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?php
        if ($model->isNewRecord) {
            echo Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> Save',
                [
                'id' => 'save-'.$model->formName(),
                'class' => 'btn btn-success',
                'onClick' => "$('#nextAction').val('done');",
                ]
            );
            echo ' &nbsp; ';
            echo Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> Create more',
                [
                'id' => 'save-'.$model->formName(),
                'class' => 'btn btn-primary',
                'onClick' => "$('#nextAction').val('more');",
                ]
            );
        } else {
            echo Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> Save',
                [
                'id' => 'save-'.$model->formName(),
                'class' => 'btn btn-success',
                ]
            );
        }
        ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS

	$(function () {
        $('.newsi-opts').click(function(){
            newSi = $(this).val();

            if (newSi === 'yes') {
                $('#input-picksi').popover('hide');
                $('#input-picksi').hide({
                    effect: 'blind',
                    complete: function(){
                        $('#input-newsi').show({
                            effect: 'blind',
                            complete: function(){
                                $('#jobcontainerform-shippinginstructionnumber').focus();
                            }
                        });
                    }
                });
            } else {
                $('#input-newsi').hide({
                    effect: 'blind',
                    complete: function(){
                        $('#input-picksi').show({
                            effect: 'blind',
                            complete: function(){
                                $('#jobcontainerform-shippinginstruction_id').select2('open');
                                $('#input-picksi').popover('show');
                            }
                        });
                    }
                });
            }
        });

        $('.newsi-opts').keypress(function(event) {
            if ( event.which == 13 ) {
                $(this).click();
                event.preventDefault();
            }
        });

        $('#select2-jobcontainerform-shippinginstruction_id-results').popover({
            title: "<strong>Petunjuk</strong>",
            content: "<p>4 digit angka, spasi, 2 digit kode,spasi, 3 digit kota.</p><p>Contoh : 0001 EE SRG</p><p><b>EE</b> : Emkl Ekspor<br/><b>EI</b> : Emkl Impor<br/><b>JPR</b> : Jepara<br/><b>SLO</b> : Solo<br/><b>SRG</b> : Semarang<br/><b>YGY</b> : Yogyakarta<br/></p>",
            html: true,
            placement: "bottom"
        });

        $('#jobcontainerform-shippinginstruction_id').on('select2:open', function () {
            $('#select2-jobcontainerform-shippinginstruction_id-results').popover('show');
        });

        $('#jobcontainerform-shippinginstruction_id').on('select2:close', function () {
            $('#select2-jobcontainerform-shippinginstruction_id-results').popover('hide');
            $('#jobcontainerform-containernumber').focus();
        });

        $('#jobcontainerform-shippinginstructionnumber').popover({
            title: "<strong>Petunjuk</strong>",
            content: "<p>4 digit angka, spasi, 2 digit kode,spasi, 3 digit kota.</p><p>Contoh : 0001 EE SRG</p><p><b>EE</b> : Emkl Ekspor<br/><b>EI</b> : Emkl Impor<br/><b>JPR</b> : Jepara<br/><b>SLO</b> : Solo<br/><b>SRG</b> : Semarang<br/><b>YGY</b> : Yogyakarta<br/></p>",
            html: true,
            placement: "bottom"
        });

        $('#jobcontainerform-shippinginstructionnumber').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-shipperid').select2('open');
                event.preventDefault();
            }
        });

        $('#jobcontainerform-shippinginstructionnumber').focus(function(event) {
            $(this).popover('show');
        });

        $('#jobcontainerform-shippinginstructionnumber').blur(function(event) {
            $(this).popover('hide');
        });

        $('#jobcontainerform-shipperid').on('select2:close', function (event) {
            newSi = $('input[name="JobContainerForm[newSi]"]:checked.newsi-opts').val();
            shipper = $(this).val();

            if (newSi === 'yes' && shipper && isNaN(shipper)) {
                $('#input-shipperdetail').show({
                    effect: 'blind',
                    complete: function(){
                        $('#jobcontainerform-shipperaddress').focus();
                    }
                });
            } else {
                $('#input-shipperdetail').hide({
                    effect: 'blind',
                    complete: function(){
                        setTimeout(function() {
                            shipper = $('#jobcontainerform-shipperid').val();

                            if (shipper) {
                                $('#jobcontainerform-shippingid').select2('open');
                            } else {
                                $('#jobcontainerform-shippingid').select2('close');
                            }
                        }, 300);
                    }
                });
            }
        });

        $('#jobcontainerform-shippingid').on('select2:close', function (event) {
            setTimeout(function() {
                shipping = $(this).val();

                if (shipping) {
                    $('#jobcontainerform-destinationid').select2('open');
                } else {
                    $('#jobcontainerform-destinationid').select2('close');
                }
            }, 300);
        });

        $('#jobcontainerform-destinationid').on('select2:close', function (event) {
            $('#jobcontainerform-size').focus();
        });

        $('#jobcontainerform-containernumber').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-size').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-size').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-type_id').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-type_id').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-sealnumber').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-sealnumber').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-stuffingdate').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-stuffingdate').keypress(function(event) {
            if ( event.which == 13 ) {
                $(this).blur();
                $('#jobcontainerform-containerdepo_id').select2('open');
                event.preventDefault();
            }
        });

        $('#jobcontainerform-containerdepo_id').on('select2:close', function (event) {
            setTimeout(function() {
                depo = $(this).val();

                if (depo) {
                    $('#jobcontainerform-stuffinglocation_id').select2('open');
                } else {
                    $('#jobcontainerform-stuffinglocation_id').select2('close');
                }
            }, 300);
        });

        $('#jobcontainerform-stuffinglocation_id').on('select2:close', function (event) {
            setTimeout(function() {
                loc = $(this).val();

                if (loc) {
                    $('#jobcontainerform-supervisor_id').select2('open');
                } else {
                    $('#jobcontainerform-supervisor_id').select2('close');
                }
            }, 300);
        });

        $('#jobcontainerform-supervisor_id').on('select2:close', function (event) {
            setTimeout(function() {
                loc = $(this).val();

                if (loc) {
                    $('#jobcontainerform-truckvendor_id').select2('open');
                } else {
                    $('#jobcontainerform-truckvendor_id').select2('close');
                }
            }, 300);
        });

        $('#jobcontainerform-truckvendor_id').on('select2:close', function (event) {
            $('#jobcontainerform-drivername').focus();
        });

        $('#jobcontainerform-drivername').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-cellphone').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-cellphone').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-policenumber').focus();
                event.preventDefault();
            }
        });

        $('#jobcontainerform-policenumber').keypress(function(event) {
            if ( event.which == 13 ) {
                $('#jobcontainerform-notes').focus();
                event.preventDefault();
            }
        });

        // first trigger

        $('input[name="JobContainerForm[newSi]"]:checked.newsi-opts').click().focus();

        shipper = $('#jobcontainerform-shipperid').val();

        if (shipper && isNaN(shipper)) {
            $('#input-shipperdetail').show();
        } else {
            $('#input-shipperdetail').hide();
        }

	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

