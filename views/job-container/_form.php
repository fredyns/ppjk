<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use kartik\widgets\Select2;
use app\models\form\JobContainerForm;
use app\models\CompanyProfile;
use app\models\Shipping;
use app\models\ContainerPort;
use app\models\StuffingLocation;
use app\models\Profile;
use app\models\TruckSupervisor;

/**
 * @var yii\web\View $this
 * @var app\models\JobContainer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<style>
    #jobcontainerform-newsi .radio {
        float: left;
        margin-right: 10px;
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
            $form->field($model, 'newSi')->radioList(JobContainerForm::optsNewSi());
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
                            'minimumInputLength' => 3,
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
                $form->field($model, 'shippingInstructionNumber')->textInput(['maxlength' => true])
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
                                    'url' => Url::to(['/api/company-profile/list']),
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
                    if (($shipping = Shipping::findOne($model->shippingId)) !== null) {
                        $shippingLabel = $shipping->name;
                    }
                }

                echo $form
                    ->field($model, 'shippingId')
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
                                'url' => Url::to(['/api/shipping/list']),
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

        </div>

        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('main'); ?>

        <!-- attribute containerNumber -->
        <?=
        $form->field($model, 'containerNumber')->textInput(['maxlength' => true])
        ?>

        <!-- attribute sealNumber -->
        <?=
        $form->field($model, 'sealNumber')->textInput(['maxlength' => true])
        ?>

        <!-- attribute stuffingDate -->
        <?=
            $form
            ->field($model, 'stuffingDate')
            ->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
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
                    'minimumInputLength' => 3,
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

        <!-- attribute driver_id -->
        <?php
        $driverLabel = $model->driver_id;

        if ($model->driver_id > 0) {
            if (($driver = Profile::findOne($model->driver_id)) !== null) {
                $driverLabel = $driver->name;
            }
        }

        echo $form
            ->field($model, 'driver_id')
            ->widget(Select2::classname(),
                [
                'initValueText' => $driverLabel,
                'options' => ['placeholder' => 'mencari sopir ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/personel/driver-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(item) { return item.text; }'),
                    'templateSelection' => new JsExpression('function (item) { return item.text; }'),
                ],
        ]);
        ?>

        <div id="input-driverdetail">

            <!-- attribute driverPhone -->
            <?=
            $form->field($model, 'driverPhone')->textInput(['maxlength' => true])
            ?>

        </div>

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
                    'minimumInputLength' => 3,
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
                    'label' => Yii::t('app', 'JobContainer'),
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
        $('#input-driverdetail').hide();
        $('#input-shipperdetail').hide();
        $('#input-shipper').hide();
        $('#input-newsi').hide();
        $('#input-picksi').show();

        $('input[name="JobContainerForm[newSi]"]').click(function(){
            newSi = $(this).val();

            if (newSi === 'yes') {
                $('#input-newsi').show('blind');
                $('#input-shipper').show('blind');
                $('#input-picksi').hide('blind');
            } else if (newSi === 'no') {
                $('#input-shipper').hide('blind');
                $('#input-newsi').hide('blind');
                $('#input-picksi').show('blind');
            } else {
                alert("New SI: " + newSi);
            }

            $( "#jobcontainerform-shipperid" ).trigger("select2:select");

        });

        $('#jobcontainerform-shipperid').on('select2:select', function (evt) {
            shipper = $(this).val();

            if (shipper && isNaN(shipper))
            {
                $('#input-shipperdetail').show('blind');
            } else {
                $('#input-shipperdetail').hide('blind');
            }
        });

        $('#jobcontainerform-driverid').on('select2:select', function (evt) {
            driver = $(this).val();

            if (driver && isNaN(driver))
            {
                $('#input-driverdetail').show('blind');
            } else {
                $('#input-driverdetail').hide('blind');
            }
        });

	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

