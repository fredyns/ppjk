<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View  */
/* @var $model app\models\CompanyProfile  */

Pjax::begin([
    'id' => 'pjax-SiServices',
    'enableReplaceState' => false,
    'linkSelector' => '#pjax-SiServices ul.pagination a, th a',
    'clientOptions' => [
        'pjax:success' => 'function(){alert(\"yo\")}',
    ],
]);

$jobContainerActControl = new \app\actioncontrols\JobContainerActControl;

$addJobContainer = $jobContainerActControl->button('create',
    [
    'label' => 'New Container',
    'urlOptions' => [
        'JobContainerForm' => ['shippingId' => $model->id],
    ],
    ]);

echo '<div class=\"table-responsive\">';
echo GridView::widget([
    //'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getSiServices(),
        'pagination' => [
            'pageSize' => 50,
            'pageParam' => 'page-siservices',
        ],
        'sort' => [
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
        ],
        ]),
    'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => 'First',
        'lastPageLabel' => 'Last'
    ],
    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
    'headerRowOptions' => ['class' => 'x'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'class' => 'fredyns\suite\grid\KartikViewColumn',
            'actionControl' => 'app\actioncontrols\ShippingInstructionActControl',
            'attribute' => 'number',
        ],
        [
            'attribute' => 'shipper_id',
            'options' => [],
            'format' => 'raw',
            'value' => function ($model) {
                return \fredyns\suite\widgets\LinkedDetail::widget([
                        'model' => $model,
                        'attribute' => 'shipper',
                        'actionControl' => 'app\actioncontrols\CompanyProfileActControl',
                ]);
            },
        ],
        // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::columnFormat
        [
            'attribute' => 'destination_id',
            'options' => [],
            'format' => 'raw',
            'value' => function ($model) {
                return \fredyns\suite\widgets\LinkedDetail::widget([
                        'model' => $model,
                        'attribute' => 'destination',
                        'actionControl' => 'app\actioncontrols\ContainerPortActControl',
                ]);
            },
        ],
        // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
        [
            'class' => 'fredyns\suite\grid\KartikActionColumn',
            'actionControl' => 'app\actioncontrols\ShippingInstructionActControl',
        ],
    ],
    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
    'pjax' => false, // pjax is set to always true for this demo
    'toolbar' => [
        $addJobContainer.' {export}',
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
            'filename' => $this->title.' - SiServices',
        ],
        GridView::PDF => [
            'label' => 'Save as PDF',
            'filename' => $this->title.' - SiServices',
        ],
    ],
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => false,
    ],
    'panelBeforeTemplate' => '
            <div class="clearfix">{summary}</div>
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
echo '</div>';

Pjax::end();
