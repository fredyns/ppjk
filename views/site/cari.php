<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\grid\GridView;
use jino5577\daterangepicker\DateRangePicker;
use app\models\JobContainer;
use app\models\ContainerType;
use app\actioncontrols\ShippingInstructionActControl;
use app\models\search\JobContainerSearch;

/* @var $this yii\web\View  */
/* @var $dataProvider yii\data\ActiveDataProvider  */
/* @var $searchModel app\models\search\JobContainerPublicSearch  */

$this->title = Yii::t('app', 'Job Containers');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>

    .inline-label {
        font-size: 0.7em;
    }
    .uppercase {
        text-transform: uppercase;
    }

</style>

<div class="giiant-crud job-container-index">

    <h1>
        <?= Yii::t('app', 'Search Containers') ?>
    </h1>

    <div class="job-container-search">

        <?php
        $form = ActiveForm::begin([
                'action' => ['cari'],
                'layout' => 'horizontal',
                'method' => 'get',
        ]);
        ?>

        <?=
            $form
            ->field($searchModel, 'deliveryOrder')
            ->textInput()
            ->widget(
                MaskedInput::className(), [
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

        <?= $form->field($searchModel, 'shipperName') ?>

        <?=
            $form
            ->field($searchModel, 'containerNumber')
            ->textInput()
            ->widget(
                MaskedInput::className(), [
                'mask' => JobContainer::CONTAINERNUMBERMASK,
                'options' => [
                    'class' => 'form-control uppercase',
                    'maxlength' => true,
                ],
                'clientOptions' => [
                    'greedy' => false,
                    'removeMaskOnSubmit' => true,
                ],
                ]
        );
        ?>

        <?=
            $form
            ->field($searchModel, 'stuffingDate')
            ->widget(\yii\jui\DatePicker::classname(), [
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control'],
                ]
        );
        ?>
        <div class="form-group field-submit">
            <label class="control-label col-sm-3" for="submit">&nbsp;</label>
            <div class="col-sm-6">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>                
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::errorSummary($searchModel); ?>
        </div>
    </div>

    <div class="table-responsive">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'attribute' => 'deliveryOrder',
                ],
                [
                    'label' => 'Date',
                    'attribute' => 'stuffingDate',
                    'options' => [
                        'width' => '60px',
                    ],
                    'value' => function ($model) {
                        $date = new \Datetime($model->stuffingDate);

                        return ($date) ? $date->format('d M') : '-';
                    },
                ],
                [
                    'label' => 'Cont. Number',
                    'class' => 'fredyns\suite\grid\KartikViewColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                    'attribute' => 'containerNumber',
                    'options' => [
                        'width' => '120px',
                    ],
                    'value' => function (JobContainer $model, $key, $index, $widget) {
                        return $model->containerNumberFormated;
                    },
                ],
                [
                    'attribute' => 'size',
                    'value' => function ($model) {
                        return $model->size ? $model->sizeLabel : '-';
                    },
                ],
                [
                    'attribute' => 'type_id',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'type.name', '-');
                    },
                ],
                [
                    'label' => 'Shipper',
                    'attribute' => 'shipperName',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'shipper.name', '-');
                    },
                ],
                [
                    'label' => 'Location',
                    'attribute' => 'stuffingLocationName',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'stuffingLocation.name', '-');
                    },
                ],
                //'notes',
                [
                    'class' => 'fredyns\suite\grid\KartikActionColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                ],
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => false, // pjax is set to always true for this demo
            'export' => [
                'icon' => 'export',
                'label' => 'Export',
            ],
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => true,
            'pageSummaryRowOptions' => [
                'class' => 'kv-page-summary',
                'style' => 'height: 100px;'
            ],
            'persistResize' => false,
            'exportConfig' => [
                GridView::EXCEL => [
                    'label' => 'Save as EXCEL',
                    'filename' => 'Job Containers',
                ],
                GridView::PDF => [
                    'label' => 'Save as PDF',
                    'filename' => 'Job Containers',
                ],
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
            ],
            'panelBeforeTemplate' => '
                <div class="pull-right">
                    <div class="btn-toolbar kv-grid-toolbar" role="toolbar">
                        {toolbar}
                    </div>
                </div>
                <div class="pull-left">
                    <div class="kv-panel-pager">
                        {pager}
                    </div>
                </div>
                {before}
                <div class="clearfix"></div>
            ',
        ]);
        ?>

    </div>

</div>
