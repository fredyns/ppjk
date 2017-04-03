<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\JobContainer;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\JobContainerSearch $searchModel
 */
$this->title = Yii::t('app', 'Search');
$this->params['breadcrumbs'][] = ['label' => 'Search', 'url' => ['search', 'number' => $searchTerm]];
?>

<div class="giiant-crud site-search">

    <h1>
        <?= Yii::t('app', 'Search Containers') ?>
    </h1>

    <div class="job-container-search">

        <?php
        $form = ActiveForm::begin([
                'action' => ['search'],
                'method' => 'get',
        ]);
        ?>

        <div class="form-group field-number required">
            <label class="col-lg-3 control-label" for="number">Container Number</label>
            <div class="col-lg-9">
                <?=
                MaskedInput::widget([
                    'id' => "search-input",
                    'name' => "number",
                    'value' => $searchTerm,
                    'mask' => JobContainer::CONTAINERNUMBERMASK,
                    'options' => [
                        'maxlength' => true,
                        'class' => "form-control mytooltip",
                        'style' => "text-transform: uppercase;",
                        'placeholder' => Yii::t('app', 'Search Container')."...",
                        'title' => "Type the 11-digit number of container, with no spaces",
                        'data-toggle' => "tooltip",
                        'data-placement' => "bottom",
                    ],
                    'clientOptions' => [
                        'greedy' => false,
                        'removeMaskOnSubmit' => true,
                    ],
                ]);
                ?>
            </div>
        </div>

        <br/>
        <br/>

        <div class="form-group col-sm-offset-3 col-lg-9">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <hr/>

    <div class="clearfix"></div>

    <?php if (count($containers) > 1): ?>
        <?= $this->render('search/list', ['containers' => $containers]); ?>
    <?php elseif (count($containers) == 1): ?>
        <?= $this->render('search/view', ['model' => $containers[0]]); ?>
    <?php elseif (empty($searchTerm)): ?>
        <div class="help-block help-block-error ">
            Please type Container Number to search.
        </div>
    <?php elseif (strlen($searchTerm) < 6): ?>
        <div class="help-block help-block-error ">
            Container Number is too short.
        </div>
    <?php elseif (empty($containers)): ?>
        <div class="help-block help-block-error ">
            Container not found.
        </div>
    <?php else: ?>
        ...
    <?php endif; ?>

</div>
