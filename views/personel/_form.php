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

/**
 * @var yii\web\View $this
 * @var app\models\Personel $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="personel-form">

    <?php
    $form = ActiveForm::begin([
            'id' => 'Personel',
            'layout' => 'horizontal',
            'enableClientValidation' => true,
            'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);

    echo Html::hiddenInput('ru', ReturnUrl::getRequestToken());
    ?>

    <div class="">
        <?php $this->beginBlock('company'); ?>

        <!-- attribute companyProfile_id -->
        <?=
            $form
            ->field($model, 'companyProfile_id')
            ->label('Company Name')
            ->widget(Select2::classname(),
                [
                'initValueText' => ArrayHelper::getValue($model, 'companyProfile.name'),
                'options' => [
                    'placeholder' => 'mencari perusahaan ...',
                ],
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
                    'templateResult' => new JsExpression('function(itemData) { return itemData.text; }'),
                    'templateSelection' => new JsExpression('function (itemData) { return itemData.text; }'),
                ],
        ]);
        ?>

        <div id="input-companydetail">

            <!-- attribute companyAddress -->
            <?=
            $form->field($model, 'companyAddress')->textarea(['rows' => 3])
            ?>

            <!-- attribute companyPhone -->
            <?=
            $form->field($model, 'companyPhone')->textInput(['maxlength' => true])
            ?>

            <!-- attribute companyEmail -->
            <?=
            $form->field($model, 'companyEmail')->textInput(['maxlength' => true])
            ?>

        </div>

        <?php $this->endBlock(); ?>

        <?php $this->beginBlock('profile'); ?>

        <!-- attribute profile_id -->
        <?=
            $form
            ->field($model, 'profile_id')
            ->label('Profile Name')
            ->widget(Select2::classname(),
                [
                'initValueText' => ArrayHelper::getValue($model, 'profile.name'),
                'options' => [
                    'placeholder' => 'mencari profile ...',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'tags' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'menunggu hasil...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/api/profile/list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(itemData) { return itemData.text; }'),
                    'templateSelection' => new JsExpression('function (itemData) { return itemData.text; }'),
                ],
        ]);
        ?>

        <div id="input-profiledetail">

            <!-- attribute profilePhone -->
            <?=
            $form->field($model, 'profilePhone')->textInput(['maxlength' => true])
            ?>

        </div>

        <!-- attribute title -->
        <?=
        $form->field($model, 'title')->textInput(['maxlength' => true])
        ?>

        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [
                [
                    'label' => Yii::t('app', 'Company'),
                    'content' => $this->blocks['company'],
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
                    'label' => Yii::t('app', 'Profile'),
                    'content' => $this->blocks['profile'],
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

	$(function () {
        $('#input-companydetail').hide();
        $('#input-profiledetail').hide();

        $('#personelform-companyprofile_id').on('select2:select', function (evt) {
            company = $(this).val();

            if (company && isNaN(company)) {
                $('#input-companydetail').show('blind');
            } else {
                $('#input-companydetail').hide('blind');
            }
        });

        $('#personelform-profile_id').on('select2:select', function (evt) {
            profile = $(this).val();

            if (profile && isNaN(profile)) {
                $('#input-profiledetail').show('blind');
            } else {
                $('#input-profiledetail').hide('blind');
            }
        });

	});

JS;

$this->registerJs($js, \yii\web\View::POS_READY);


