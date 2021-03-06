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
                'deliveryOrder',
                [
                    'label' => 'Cont. Number',
                    'class' => 'fredyns\suite\grid\KartikViewColumn',
                    'actionControl' => 'app\actioncontrols\JobContainerActControl',
                    'attribute' => 'containerNumber',
                    'options' => [
                        'width' => '120px',
                    ],
                    'visible' => (!Yii::$app->user->isGuest),
                    'value' => function (JobContainer $model, $key, $index, $widget) {
                        return $model->containerNumberFormated;
                    },
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
                                $model->containerNumberFormated
                                ,
                                [
                                '/site/search',
                                'number' => $model->deliveryOrder,
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
