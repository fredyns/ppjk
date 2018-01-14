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
use app\models\ShippingInstruction;
use app\models\TruckSupervisor;

/* @var $this \yii\web\View $this */
/* @var $model \app\models\JobContainer  */
/* @var $form \yii\widgets\ActiveForm  */
?>

<style>

    #select2-jobcontainerform-shipper_id-results li, #select2-jobcontainerform-shipper_id-container {
        text-transform: uppercase;
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

        <br/>
        <div id="input-si">

            <!-- attribute deliveryOrder -->
            <?=
                $form
                ->field($model, 'deliveryOrder')
                ->textInput()
                ->widget(
                    MaskedInput::className(),
                    [
                    'mask' => JobContainer::DOMASK,
                    'options' => [
                        'class' => 'form-control uppercase',
                        'maxlength' => 12,
                        'placeholder' => 'isian nomor SI...',
                    ],
                    'clientOptions' => [
                        'greedy' => false,
                        'removeMaskOnSubmit' => false,
                    ],
                    ]
            );
            ?>

            <!-- petunjuk format nomor DO -->
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

            <div id="input-sidetail">

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
                    ->label('Shipper Name')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => $shipperLabel,
                        'options' => ['placeholder' => 'mencari perusahaan ...'],
                        'pluginOptions' => [
                            'tags' => true,
                            'minimumInputLength' => 2,
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

        <br/>
        <div id="input-container">

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
                        'maxlength' => 12,
                    ],
                    'clientOptions' => [
                        'greedy' => false,
                        'removeMaskOnSubmit' => true,
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
                ->widget(\yii\jui\DatePicker::classname(),
                    [
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                    ]
            );
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

            <div id="input-spvdetail">

                <!-- attribute supervisorPhone -->
                <?=
                $form->field($model, 'supervisorPhone')->textInput(['maxlength' => true])
                ?>

            </div>

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

        </div>

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
                'onClick' => "$('#nextAction').val('index');",
                ]
            );
            echo ' &nbsp; ';
            echo Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> Create more',
                [
                'id' => 'save-'.$model->formName(),
                'class' => 'btn btn-primary',
                'onClick' => "$('#nextAction').val('create');",
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
$js= $this->render('_form.js');
$this->registerJs($js, \yii\web\View::POS_READY);

