<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use cornernote\returnurl\ReturnUrl;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\search\ContainerTypeSearch */

$this->title = Yii::t('app', 'Container Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud container-type-index">

    <h1>
        <?= Yii::t('app', 'Container Types') ?>
        <small class="badge">
            List
        </small>
    </h1>

    <?php //echo $this->render('_search', ['model' =>$searchModel]);?>

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
                    'class' => 'fredyns\suite\grid\KartikViewColumn',
                    'actionControl' => 'app\actioncontrols\ContainerTypeActControl',
                    'attribute' => 'name',
                ],
                [
                    'class' => 'fredyns\suite\grid\KartikActionColumn',
                    'actionControl' => 'app\actioncontrols\ContainerTypeActControl',
                ],
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => false, // pjax is set to always true for this demo
            'toolbar' => [
                $actionControl->button('create').' {export}',
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
                    'filename' => 'Container Types',
                ],
                GridView::PDF => [
                    'label' => 'Save as PDF',
                    'filename' => 'Container Types',
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
