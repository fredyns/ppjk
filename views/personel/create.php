<?php

use yii\helpers\Html;
use yii\helpers\Url;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var app\models\Personel $model
 */

$this->title = $actionControl->breadcrumbLabel('create');
$this->params['breadcrumbs'][] = $actionControl->breadcrumbItem('index');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud personel-create">

    <h1>
        <?= Yii::t('app', 'Personel') ?>
        <small>
            new
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('Cancel', ReturnUrl::getUrl(Url::previous()), ['class' => 'btn btn-default']); ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', ['model' => $model]); ?>

</div>
