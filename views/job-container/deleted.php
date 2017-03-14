<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\JobContainerSearch $searchModel
 */
$this->title = Yii::t('app', 'Job Containers');
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .inline-label {
        font-size: 0.7em;
    }
</style>

<div class="giiant-crud job-container-deleted">

    <h1>
        <?= Yii::t('app', 'Job Containers') ?>
        <small class="badge">
            Deleted
        </small>
    </h1>

    <?php //echo $this->render('_search', ['model' =>$searchModel]); ?>

    <?php
    \yii\widgets\Pjax::begin([
        'id' => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector' => '#pjax-main ul.pagination a, th a',
        'clientOptions' => [
            'pjax:success' => 'function(){alert(\"yo\")}',
        ],
    ]);
    ?>

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
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'Shipping Inst.',
                    'attribute' => 'shippingInstructionNumber',
                    'format' => 'html',
                    'value' => function (JobContainer $model, $key, $index, $widget) {
                        return 'SI <b>#'.$model->shippingInstruction->number.'</b>'
                            .' &nbsp;<i class="inline-label">from</i> '
                            .$model->shippingInstruction->shipper->name
                            .' &nbsp;<i class="inline-label">to</i> '
                            .$model->shippingInstruction->destination->name
                            .' &nbsp;<i class="inline-label">with</i> '
                            .$model->shippingInstruction->shipping->name;
                    },
                    'group' => true, // enable grouping,
                    'groupedRow' => true, // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'label' => 'Date',
                    'attribute' => 'stuffingDate',
                    'value' => function ($model) {
                        $date = new \Datetime($model->stuffingDate);

                        return ($date) ? $date->format('d M') : '-';
                    },
                ],
                [
                    'class' => 'fredyns\suite\grid\KartikViewColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                    'attribute' => 'containerNumber',
                ],
                [
                    'attribute' => 'size',
                    'filter' => JobContainer::optsSize(),
                ],
                [
                    'attribute' => 'type_id',
                    'filter' => ContainerType::options(),
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'type.name', '-');
                    },
                ],
                [
                    'label' => 'Depo',
                    'attribute' => 'containerDepoName',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'containerDepo.name', '-');
                    },
                ],
                [
                    'label' => 'Location',
                    'attribute' => 'stuffingLocationName',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'stuffingLocation.name', '-');
                    },
                ],
                'notes',
                [
                    'class' => 'fredyns\suite\grid\KartikActionColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                ],
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => false, // pjax is set to always true for this demo
            'toolbar' => [
                '{export}',
            ],
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

    <?php \yii\widgets\Pjax::end(); ?>

</div>
