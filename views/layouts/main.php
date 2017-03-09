<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

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
    app\assets\SliderAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $js = <<< 'SCRIPT'
        $(function () {
            $("#navbar-search-input").tooltip();
        });
SCRIPT;
    $this->registerJs($js, \yii\web\View::POS_READY);
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
                                <form action="<?= Url::to(['/site/search']); ?>" method="get" class="navbar-form navbar-left" role="search">
                                    <div class="form-group">
                                        <style>
                                            #navbar-search-input + .tooltip > .tooltip-inner {
                                                background-color: #73AD21;
                                                color: #FFFFFF;
                                                border: 1px solid green;
                                                padding: 8px;
                                                font-size: 16px;
                                            }
                                        </style>
                                        <input
                                            type="text"
                                            name="number"
                                            class="form-control"
                                            id="navbar-search-input"
                                            placeholder="<?= Yii::t('app', 'Search Container') ?>..."
                                            title="Type the 11-digit number of container, with no spaces"
                                            data-toggle='tooltip'
                                            data-placement="bottom"
                                            />
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

                <div class="content-wrapper">
                    <section class="content-header" style="min-height: 31px;">
                        <?=
                        Breadcrumbs::widget(
                            [
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]
                        )
                        ?>
                    </section>

                    <section class="content">
                        <?= Alert::widget() ?>

                        <div class="callbacks_container">
                            <?=
                            Html::ul(
                                [
                                Html::img('@web/jasco/slide/slide001a.jpg'),
                                Html::img('@web/jasco/slide/slide002a.jpg'),
                                Html::img('@web/jasco/slide/slide003a.jpg'),
                                Html::img('@web/jasco/slide/slide004a.jpg'),
                                Html::img('@web/jasco/slide/slide005a.jpg'),
                                ]
                                ,
                                [
                                'class' => "rslides",
                                'id' => "slider",
                                'encode' => false,
                                ]
                            );
                            ?>
                        </div>

                        <?php
                        $js = <<<JS

	$(function () {

      $("#slider").responsiveSlides({
        auto: true,
        pager: false,
        nav: true,
        speed: 100,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

	});

JS;

                        $this->registerJs($js, \yii\web\View::POS_READY);
                        ?>
                        <div class="row">

                            <div class="col-md-8">

                                <?= $content ?>

                            </div>

                            <div class="col-md-4">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            SEMARANG - HEAD OFFICE
                                        </h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        Perkantoran Mutiara Marina No. 5<br/>
                                        Jl. Marina – Semarang 50144<br/>
                                        T. +62 24 761 4495 (HUNTING)<br/>
                                        F. +62 24 761 2095 / 97<br/>
                                        Email : info@jasco-logistics.com
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            JAKARTA
                                        </h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="display: block;">
                                        Jl. Kebon Bawang No 16 A<br/>
                                        (D/h : Jalan Fort Barat)<br/>
                                        Tanjung Priok, Jakarta Utara 14320<br/>
                                        T. +62 21 4374 345<br/>
                                        F. +62 21 4390 9840<br/>
                                        Mobile : 0815 9212 090, 0877 7001 1043<br/>
                                        Email   : maman.jkt@jasco-logistics.com
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            SOLO
                                        </h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="display: block;">
                                        Griya Batas Kota No. 10<br/>
                                        Makamhaji, Solo, 57137 <br/>
                                        T/F. +62 271 711 918<br/>
                                        Email : enia.slo@jasco-logistics.com
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            YOGYAKARTA
                                        </h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="display: block;">
                                        Jl Ring Road Utara No 39<br/>
                                        Maguwoharjo, Depok, Sleman 55282<br/>
                                        T/F. +62 274 4333 642<br/>
                                        Email : miko.slo@jasco-logistics.com

                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            JEPARA
                                        </h3>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body" style="display: block;">
                                        JL. Raya Soekarno - Hatta KM 5.5 Tahunan<br/>
                                        Jepara, Jawa Tengah <br/>
                                        T/F. +62 291 597 761<br/>
                                        Email : feric.jpr@jasco-logistics.com
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>

                        </div>

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

            </div>

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
