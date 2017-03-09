<?php

use yii\helpers\Html;
use kartik\icons\Icon;
use app\actioncontrols\JobContainerActControl;

$containerAct = new JobContainerActControl;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

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

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <?php if ($containerAct->allowCreate): ?>
                    <li class="">
                        <?=
                        Html::a(
                            Icon::show('plus').' '.Yii::t('app', 'New Container')
                            , $containerAct->urlCreate
                        );
                        ?>
                    </li>
                <?php endif; ?>

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="pull-left image img-circle" style="width: 25px; height: 25px; overflow: hidden">
                            <?php
                            $profile = Yii::$app->user->identity->profile;

                            if (!empty($profile->picture_id)) {
                                echo Html::img(
                                    ['/file', 'id' => $profile->picture_id],
                                    [
                                    'alt' => $profile->user->username,
                                    'style' => 'max-length: 25px; max-width: 25px;',
                                    ]
                                );
                            } else {
                                echo Html::img(
                                    '@web/image/user-160.png',
                                    [
                                    'alt' => "User Image",
                                    'style' => 'max-length: 25px; max-width: 25px;',
                                    ]
                                );
                            }
                            ?>
                        </div>
                        <span class="hidden-xs">
                            &nbsp; <?= Yii::$app->user->identity->username; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <div class="image img-circle" style="width: 90px; height: 90px; overflow: hidden; margin: 0 auto;">
                                <?php
                                $profile = Yii::$app->user->identity->profile;

                                if (!empty($profile->picture_id)) {

                                    echo Html::img(
                                        ['/file', 'id' => $profile->picture_id],
                                        [
                                        'style' => 'max-length: 90px; max-width: 90px;',
                                        'alt' => $profile->user->username,
                                        ]
                                    );
                                } else {
                                    echo Html::img(
                                        '@web/image/user-160.png',
                                        [
                                        'alt' => "User Image",
                                        'style' => 'max-length: 90px; max-width: 90px;',
                                        ]
                                    );
                                }
                                ?>
                            </div>
                            <p>
                                <?php
                                $name = Yii::$app->user->identity->profile->name;
                                echo empty($name) ? Yii::$app->user->identity->username : $name;
                                ?>
                                <small>
                                    <?=
                                    Yii::t('user', 'Member Since {0, date}', $profile->user->created_at)
                                    ?>
                                </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?=
                                Html::a(
                                    'Profile', ['/user/profile/show', 'id' => Yii::$app->user->id],
                                    ['class' => "btn btn-default btn-flat"]
                                );
                                ?>
                            </div>
                            <div class="pull-right">
                                <?=
                                Html::a(
                                    'Sign out', ['/user/security/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                )
                                ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less ->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->

            </ul>
        </div>
    </nav>
</header>
