<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use app\models\JobContainer;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\ContainerSearch $searchModel
 */
$this->title = Yii::t('app', 'Search Result');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="giiant-crud site-search-result">

    <div class="table-responsive">

        <?=
        GridView::widget([
            'id' => 'search-result',
            'dataProvider' => new ArrayDataProvider(['allModels' => $containers, 'pagination' => FALSE]),
            'columns' => [
                ['class' => '\kartik\grid\CheckboxColumn'],
                [
                    'label' => 'Shipping Instruction',
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
                    'label' => 'Cont. Number',
                    'class' => 'fredyns\suite\grid\KartikViewColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                    'attribute' => 'containerNumber',
                    'options' => [
                        'width' => '120px',
                    ],
                    'visible' => (!Yii::$app->user->isGuest),
                ],
                [
                    'label' => 'Cont. Number',
                    'attribute' => 'containerNumber',
                    'visible' => (Yii::$app->user->isGuest),
                    'format' => 'html',
                    'options' => [
                        'width' => '120px',
                    ],
                    'value' => function (JobContainer $model, $key, $index, $widget) {
                        return Html::a(
                                $model->containerNumber
                                ,
                                [
                                '/site/search',
                                'number' => $model->containerNumber,
                                'id' => $model->id,
                                ]
                        );
                    },
                ],
                [
                    'label' => 'Date',
                    'attribute' => 'stuffingDate',
                    'options' => [
                        'width' => '60px',
                    ],
                    'value' => function ($model) {
                        $date = new \Datetime($model->stuffingDate);

                        return ($date) ? $date->format('d M') : '-';
                    },
                ],
                [
                    'attribute' => 'size',
                    'value' => function ($model) {
                        return $model->size ? $model->sizeLabel : '-';
                    },
                ],
                [
                    'attribute' => 'type_id',
                    'value' => function ($model) {
                        return ArrayHelper::getValue($model, 'type.name', '-');
                    },
                ],
                [
                    'label' => 'Driver',
                    'attribute' => 'driverName',
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
            ],
            'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'filterRowOptions' => ['class' => 'kartik-sheet-style'],
            'pjax' => FALSE, // pjax is set to always true for this demo
            // set your toolbar
            'toolbar' => [
                '{export}',
            ],
            // set export properties
            'export' => FALSE,
            // parameters from the demo form
            'bordered' => true,
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => [
                'type' => \kartik\grid\GridView::TYPE_PRIMARY,
            ],
            'persistResize' => false,
        ]);
        ?>

    </div>

</div>
