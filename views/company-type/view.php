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
/* @var $model app\models\CompanyType */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud company-type-view">

    <h1>
        <?= Yii::t('app', 'Company Type') ?>
        <small>
            <?= $model->name ?>
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

    <?php $this->beginBlock('app\models\CompanyType'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]);
    ?>

    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('CompanyProfiles'); ?>

    <?php
    Pjax::begin([
        'id' => 'pjax-CompanyProfiles',
        'enableReplaceState' => false,
        'linkSelector' => '#pjax-CompanyProfiles ul.pagination a, th a',
        'clientOptions' => [
            'pjax:success' => 'function(){alert(\"yo\")}',
        ],
    ]);

    // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
    $CompanyProfileActControl = new \app\actioncontrols\CompanyProfileActControl;

    $addCompanyProfile = $CompanyProfileActControl->button('create',
        [
        'label' => 'New CompanyProfile',
        'urlOptions' => [
            'CompanyProfileForm' => ['companyType_id' => $model->id],
        ],
    ]);

    echo '<div class=\"table-responsive\">';
    echo GridView::widget([
        //'layout' => '{summary}{pager}<br/>{items}{pager}',
        'dataProvider' => new \yii\data\ActiveDataProvider([
            'query' => $model->getCompanyProfiles(),
            'pagination' => [
                'pageSize' => 50,
                'pageParam' => 'page-companyprofiles',
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
            'name',
            'phone',
            'email:email',
            'npwp',
            // generated by fredyns\suite\giiant\crud\providers\core\RelationProvider::relationGrid
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
            $addCompanyProfile.' {export}',
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
                'filename' => $this->title.' - CompanyProfile',
            ],
            GridView::PDF => [
                'label' => 'Save as PDF',
                'filename' => $this->title.' - CompanyProfile',
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
                'content' => $this->blocks['app\models\CompanyType'],
                'active' => true,
            ],
            [
                'content' => $this->blocks['CompanyProfiles'],
                'label' => '<small>Company Profiles <span class="badge badge-default">'
                .$model->getCompanyProfiles()->count()
                .'</span></small>',
                'active' => false,
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

</div>
