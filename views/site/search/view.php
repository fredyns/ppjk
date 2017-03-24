<?php

use dmstr\bootstrap\Tabs;
use fredyns\suite\widgets\DetailView;

/* @var $this \yii\web\View  */
/* @var $model \app\models\JobContainer */

$this->params['breadcrumbs'][] = 'View #'.$model->id;
?>

<style>
    table.detail-view th {
        width: 25%;
        min-width: 150px;
    }
</style>

<div class="giiant-crud site-search-view">

    <?php $this->beginBlock('ShippingInstruction'); ?>
    <?=
    DetailView::widget([
        'model' => $model->shippingInstruction,
        'attributes' => [
            'number',
            [
                'label' => 'Shipper',
                'attribute' => 'shipper.name',
            ],
            [
                'label' => 'Shipping',
                'attribute' => 'shipping.name',
            ],
            [
                'label' => 'Destination',
                'attribute' => 'destination.name',
            ],
        ],
    ]);
    ?>

    <?php $this->endBlock(); ?>

    <?php $this->beginBlock('JobContainer'); ?>
    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Container Number',
                'format' => 'raw',
                'value' => '<b style="letter-spacing: 2px;">'.$model->containerNumber.'</b>',
            ],
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
            'driverName',
            'cellphone',
            'policenumber',
            'notes',
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
                'label' => '<b class="">Shipping Instruction</b>',
                'content' => $this->blocks['ShippingInstruction'],
                'active' => true,
            ],
        ],
    ]);
    ?>

    <?=
    Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
                'label' => '<b class="">Job Container</b>',
                'content' => $this->blocks['JobContainer'],
                'active' => true,
            ],
        ],
    ]);
    ?>

</div>
