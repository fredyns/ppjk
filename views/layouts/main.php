<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

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

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

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
        <body class="hold-transition skin-blue layout-top-nav">
            <?php $this->beginBody() ?>
            <div class="wrapper">
                <header class="main-header">
                    <nav class="navbar navbar-static-top">
                        <div class="container">
                            <div class="navbar-header">
                                <?php
                                $logoMini = '<span class="logo-mini">'.Yii::$app->params['initials'].'</span>';
                                $logoLg = '<span class="logo-lg">'
                                    .Html::img(
                                        '@web/jasco/logo.png',
                                        [
                                        'alt' => Yii::$app->name,
                                        'style' => 'length: 70%; width: 70%;',
                                        ]
                                    )
                                    .'</span>';

                                echo Html::a($logoMini.$logoLg, Yii::$app->homeUrl, ['class' => 'logo'])
                                ?>
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                                <?=
                                Nav::widget([
                                    'options' => ['class' => 'navbar-nav'],
                                    'items' => [
                                        ['label' => 'Home', 'url' => ['/site/index']],
                                        ['label' => 'Services', 'url' => ['/site/page?slug=services']],
                                        ['label' => 'Contact', 'url' => ['/site/contact']],
                                    ],
                                ]);
                                ?>
                                &nbsp;
                                <form action="<?= Url::to(['search']); ?>" method="get" class="navbar-form navbar-left" role="search">
                                    <div class="form-group">
                                        <input type="text" name="" class="form-control" id="navbar-search-input" placeholder="Search container">
                                    </div>
                                </form>
                            </div>
                            <!-- /.navbar-collapse -->
                            <!-- Navbar Right Menu -->
                            <div class="navbar-custom-menu">
                                <?=
                                Nav::widget([
                                    'options' => ['class' => 'navbar-nav navbar-right'],
                                    'items' => [
                                        [
                                            'label' => 'Login',
                                            'url' => ['/user/security/login'],
                                            'visible' => Yii::$app->user->isGuest,
                                        ],
                                        [
                                            'label' => 'Logout',
                                            'url' => ['/user/security/logout'],
                                            'visible' => !Yii::$app->user->isGuest,
                                            'linkOptions' => ['data-method' => 'post'],
                                        ],
                                    ],
                                ]);
                                ?>
                            </div>
                            <!-- /.navbar-custom-menu -->
                        </div>
                        <!-- /.container-fluid -->
                    </nav>
                </header>

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
