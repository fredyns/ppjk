<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use cornernote\returnurl\ReturnUrl;
use app\models\CompanyType;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\CompanyProfileSearch $searchModel
 */
$this->title = Yii::t('app', 'Company Profiles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud company-profile-deleted">

    <h1>
        <?= Yii::t('app', 'Company Profiles') ?>
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
                    'actionControl' => 'app\actioncontrols\CompanyProfileActControl',
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'companyType_id',
                    'label' => 'Type',
                    'filter' => CompanyType::options(),
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'companyType.name', '-');
                    },
                ],
                'phone',
                'email',
                [
                    'class' => 'fredyns\suite\grid\KartikActionColumn',
                    'actionControl' => 'app\actioncontrols\CompanyProfileActControl',
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
                    'filename' => 'Company Profiles',
                ],
                GridView::PDF => [
                    'label' => 'Save as PDF',
                    'filename' => 'Company Profiles',
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
