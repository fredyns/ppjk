<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'adminlte/login', ['content' => $content]
    );
} else {
    \app\assets\AppAsset::register($this);
    \dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
        <head>
            <meta charset="<?= Yii::$app->charset ?>"/>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <?php $this->head() ?>
        </head>

        <style>
            .mytooltip + .tooltip > .tooltip-inner {
                background-color: #73AD21;
                color: #FFFFFF;
                border: 1px solid green;
                padding: 8px;
                font-size: 16px;
            }
        </style>

        <body class="hold-transition <?= \dmstr\helpers\AdminLteHelper::skinClass() ?> sidebar-mini">
            <?php $this->beginBody() ?>
            <div class="wrapper">

                <?=
                $this->render(
                    'adminlte/header.php', ['directoryAsset' => $directoryAsset]
                )
                ?>

                <?= $this->render('adminlte/left.php', ['directoryAsset' => $directoryAsset]) ?>

                <?=
                $this->render(
                    'adminlte/content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]
                )
                ?>

            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
