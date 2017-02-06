<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use app\models\form\JobContainerForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var app\models\JobContainer $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="job-container-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'JobContainer',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);

    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">

        <?php $this->beginBlock('ShippingInstruction'); ?>

        <div id="input-si">

            <!-- attribute newSi -->
            <?=
            $form->field($model, 'newSi')->radio(JobContainerForm::optsNewSi());
            ?>

            <div id="input-picksi">

                <!-- attribute shippingInstruction_id -->
                <?=
                    $form
                    ->field($model, 'shippingInstruction_id')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => ArrayHelper::getValue($model, 'shippingInstruction.number', '-'),
                        'options' => ['placeholder' => 'mencari shipping instruction ...'],
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
                            'templateResult' => new JsExpression('function(item) { return item.text; }'),
                            'templateSelection' => new JsExpression('function (item) { return item.text; }'),
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
                    <?=
                        $form
                        ->field($model, 'shipperId')
                        ->widget(Select2::classname(),
                            [
                            'initValueText' => ArrayHelper::getValue($model, 'shippingInstruction.shipper.name', '-'),
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
                <?=
                    $form
                    ->field($model, 'shippingId')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => ArrayHelper::getValue($model, 'shippingInstruction.shipping.name', '-'),
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
                <?=
                    $form
                    ->field($model, 'destinationId')
                    ->widget(Select2::classname(),
                        [
                        'initValueText' => ArrayHelper::getValue($model, 'shippingInstruction.destination.name', '-'),
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

        <p>

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
                $form->field($model, 'stuffingDate')
                ->widget(\yii\jui\DatePicker::classname(),
                    [
                    'dateFormat' => 'yyyy-MM-dd',
            ]);
            ?>

            <!-- attribute stuffingLocation_id -->
            <?=
                $form
                ->field($model, 'stuffingLocation_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => ArrayHelper::getValue($model, 'stuffingLocation.name', '-'),
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
            <?=
            // generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::activeField
            $form->field($model, 'driver_id')->dropDownList(
                \yii\helpers\ArrayHelper::map(app\models\Profile::find()->all(), 'id', 'name'),
                [
                'prompt' => 'Select',
                'disabled' => (isset($relAttributes) && isset($relAttributes['driver_id'])),
                ]
            );
            ?>

            <!-- attribute supervisor_id -->
            <?=
                $form
                ->field($model, 'supervisor_id')
                ->widget(Select2::classname(),
                    [
                    'initValueText' => ArrayHelper::getValue($model, 'supervisor.name', '-'),
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

        </p>

        <?php $this->endBlock(); ?>

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
        shipperInput = $('#<?= $model->formName() ?>-shipper_id').val();

        if (shipperInput && isNaN(shipperInput))
        {
            $('#input-shipperdetail').show('blind');
        } else
        {
            $('#input-shipperdetail').hide('blind');
        }
    }

</script>

<?php
$js = <<<JS

	$(function () {
        $('#input-shipperdetail').hide();
        $('#input-shipper').hide();
        $('#input-newsi').hide();
        $('#input-picksi').show();

        $('select').on('select2:select', function (evt) {
            shipper_check();
        });
	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);

