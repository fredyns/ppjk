<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use fredyns\suite\helpers\ActiveUser;
use fredyns\suite\widgets\DetailView;
use kartik\grid\GridView;

/**
 * @var yii\web\View $this
 * @var app\models\ShippingInstruction $model
 */
$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud shipping-instruction-view">

    <h1>
        <?= Yii::t('app', 'Shipping Instruction') ?>
        <small>
            <?= $model->id ?>
            <?php if ($model->recordStatus == 'deleted'): ?>
                <span class="badge">deleted</span>
            <?php endif; ?>
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

    <?php $this->beginBlock('app\models\ShippingInstruction'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'number',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\CompanyProfileActControl',
                'attribute' => 'shipper',
            ],
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\CompanyProfileActControl',
                'attribute' => 'shipping',
            ],
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::attributeFormat
            [
                'linkActControl' => 'app\actioncontrols\ContainerPortActControl',
                'attribute' => 'destination',
            ],
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

    $addJobContainer = $JobContainerActControl->button('create',
        [
        'label' => 'New JobContainer',
        'urlOptions' => [
            'JobContainerForm' => ['shippingInstruction_id' => $model->id],
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
            [
                'class' => 'fredyns\suite\grid\KartikViewColumn',
                'actionControl' => 'app\actioncontrols\JobContainerActControl',
                'attribute' => 'containerNumber',
            ],
            [
                'attribute' => 'size',
            ],
            [
                'attribute' => 'type_id',
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
                'filename' => $this->title.' - JobContainer',
            ],
            GridView::PDF => [
                'label' => 'Save as PDF',
                'filename' => $this->title.' - JobContainer',
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

    <?php $this->beginBlock('info'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'profileActControl' => 'app\actioncontrols\ProfileActControl',
        'attributes' => [
            [
                'attribute' => 'recordStatus',
                'format' => 'html',
                'value' => '<span class="badge">'.$model->recordStatus.'</span>',
            ],
            [
                'label' => 'Created',
                'blamed' => 'createdBy',
                'timestamp' => 'created_at',
            ],
            [
                'label' => 'Updated',
                'blamed' => 'updatedBy',
                'timestamp' => 'updated_at',
            ],
            [
                'label' => 'Deleted',
                'blamed' => 'deletedBy',
                'timestamp' => 'deleted_at',
            ],
        ],
    ]);
    ?>
    <?php $this->endBlock(); ?>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class=""># '.$model->id.'</b>',
                'content' => $this->blocks['app\models\ShippingInstruction'],
                'active' => true,
            ],
            [
                'content' => $this->blocks['info'],
                'label' => '<small>info</small>',
                'active' => false,
                'visible' => ActiveUser::isAdmin(),
            ],
        ],
    ]);
    ?>

    <hr/>
    <br/>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'content' => $this->blocks['JobContainers'],
                'label' => '<small>Job Containers <span class="badge badge-default">'
                .$model->getJobContainers()->count()
                .'</span></small>',
                'active' => true,
            ],
        ],
    ]);
    ?>

</div>
