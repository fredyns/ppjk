<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use cornernote\returnurl\ReturnUrl;
use dmstr\widgets\Alert;
?>
<div class="content-wrapper">
    <section class="content-header" style="min-height: 31px;">
        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        )
        ?>
        <?php if (ReturnUrl::getRequestToken()): ?>
            <span class="pull-left">
                <?= Html::a('<i class="fa fa-arrow-circle-left"></i> Back', ReturnUrl::getUrl()); ?>
            </span>
        <?php endif; ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            Copyright &copy; <?= date('Y') ?> Jasco Logistics.
            All Rights Reserved
        </p>
        <!--
        <p class="pull-right">
            Deveveloped by <a href="http://fredyns.net">fredyns.net</a>
        </p>
        -->
    </div>
</footer>

<div class='control-sidebar-bg'></div>