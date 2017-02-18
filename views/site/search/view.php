<?php

use dmstr\bootstrap\Tabs;
use fredyns\suite\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var app\models\JobContainer $model
 */
$this->params['breadcrumbs'][] = 'View #'.$model->id;
?>
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
            'containerNumber',
            'sealNumber',
            'stuffingDate',
            [
                'label' => 'Stuffing Location',
                'attribute' => 'stuffingLocation.name',
            ],
            [
                'label' => 'Driver Name',
                'attribute' => 'driver.name',
            ],
            'worknote',
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
