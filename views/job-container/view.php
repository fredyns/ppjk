<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;
use dmstr\bootstrap\Tabs;
use fredyns\suite\helpers\ActiveUser;
use fredyns\suite\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this \yii\web\View  */
/* @var $model \app\models\JobContainer */

$copyParams = $model->attributes;

$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('view');
?>
<div class="giiant-crud job-container-view">

    <h1>
        <?= Yii::t('app', 'Job Container') ?>
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
            <?= $actionControl->buttons(['update', 'copy', 'delete', 'restore']); ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('ShippingInstruction'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'deliveryOrder',
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

    <?php $this->beginBlock('app\models\JobContainer'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'containerNumber',
            [
                'label' => 'Type',
                'value' => $model->sizeLabel.' '.$model->typeName,
            ],
            'sealNumber',
            'stuffingDate:date',
            [
                'label' => 'Container Depo',
                'attribute' => 'containerDepo.name',
            ],
            [
                'label' => 'Stuffing Location',
                'attribute' => 'stuffingLocation.name',
            ],
            [
                'label' => 'Mandor Name',
                'attribute' => 'supervisor.name',
                'visible' => (!Yii::$app->user->isGuest),
            ],
            [
                'label' => 'Truck Vendor',
                'attribute' => 'truckVendor.name',
                'visible' => (!Yii::$app->user->isGuest),
            ],
            'driverName',
            'cellphone',
            'policenumber',
            'notes',
        ],
    ]);
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
        'id' => 'relation-tabs-si',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class="">Shipping Instruction</b>',
                'content' => $this->blocks['ShippingInstruction'],
                'active' => true,
            ],
        ],
    ]);
    ?>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs-cont',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class="">Job-Container</b>',
                'content' => $this->blocks['app\models\JobContainer'],
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

</div>
