<?php

use yii\helpers\Html;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var app\models\JobContainer $model
 */
    
$this->title = $actionControl->breadcrumbLabel('index')." "
    .$actionControl->breadcrumbLabel('view').', '
    .$actionControl->breadcrumbLabel('update');

$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('view');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbLabel('update');
?>
<div class="giiant-crud job-container-update">

    <h1>
        <?= Yii::t('app', 'Job Container') ?>
        <small>
            <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> ' . 'Cancel', ReturnUrl::getUrl(Url::previous()), ['class' => 'btn btn-default']) ?>
        <?= $actionControl->button('view'); ?>
    </div>

    <hr />

    <?= $this->render('_form', ['model' => $model]); ?>

</div>
