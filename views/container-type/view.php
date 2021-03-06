<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use fredyns\suite\helpers\ActiveUser;
use fredyns\suite\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\ContainerType */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud container-type-view">

    <h1>
        <?= Yii::t('app', 'Container Type') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= $actionControl->buttons(['index', 'create']); ?>
        </div>

        <div class="pull-right">
            <?= $actionControl->buttons(['update', 'delete', 'restore']); ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('app\models\ContainerType'); ?>    
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]);
    ?>
    
    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('JobContainers'); ?>

    <?php 
    Pjax::begin([
        'id' => 'pjax-JobContainers',
        'enableReplaceState' => false,
        'linkSelector' => '#pjax-JobContainers ul.pagination a, th a',
        'clientOptions' => [
            'pjax:success' => 'function(){alert(\"yo\")}',
        ],
    ]);

    // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
    $JobContainerActControl = new \app\actioncontrols\JobContainerActControl;
    
    $addJobContainer = $JobContainerActControl->button('create', [
        'label' => 'New JobContainer',
        'urlOptions' => [
            'JobContainerForm' => ['type_id' => $model->id],
        ],
    ]);
    
    echo '<div class=\"table-responsive\">';
    echo GridView::widget([
        //'layout' => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getJobContainers(),
            'pagination' => [
                'pageSize' => 50,
                'pageParam' => 'page-jobcontainers',
            ]
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
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::columnFormat
            [
                'attribute' => 'shippingInstruction_id',
                'options' => [],
                'format' => 'raw',
                'value' => function ($model) {
                    return \fredyns\suite\widgets\LinkedDetail::widget([
                        'model' => $model,
                        'attribute' => 'shippingInstruction',
                        'actionControl' => 'app\actioncontrols\ShippingInstructionActControl',
                    ]);
                },
            ],
            'siNumber',
            'deliveryOrder',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::columnFormat
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
                'attribute' => 'shipping_id',
                'options' => [],
                'format' => 'raw',
                'value' => function ($model) {
                    return \fredyns\suite\widgets\LinkedDetail::widget([
                        'model' => $model,
                        'attribute' => 'shipping',
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
            'containerNumber',
            'size',
            'sealNumber',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
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
                'filename' => $this->title . ' - JobContainer',
            ],
            GridView::PDF => [
                'label' => 'Save as PDF',
                'filename' => $this->title . ' - JobContainer',
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
    ?>

    <?php $this->endBlock(); ?>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\ContainerType'],
                'active' => true,
            ],
            [
                'content' => $this->blocks['JobContainers'],
                'label' => '<small>Job Containers <span class="badge badge-default">'
                    .$model->getJobContainers()->count()
                    .'</span></small>',
                'active' => false,
            ],
        ],
    ]);
    ?>

</div>
