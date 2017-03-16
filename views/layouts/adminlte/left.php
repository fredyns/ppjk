<?php

use yii\helpers\Html;
use yii\helpers\Url;
use fredyns\suite\helpers\ActiveUser;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image img-circle" style="overflow: hidden">

                <?php
                $profile = Yii::$app->user->identity->profile;

                if (!empty($profile->picture_id)) {
                    echo Html::img(
                        ['/file', 'id' => $profile->picture_id],
                        [
                        'class' => '',
                        'alt' => $profile->user->username,
                        'style' => 'max-length: 45px; max-width: 45px;',
                        ]
                    );
                } else {
                    echo Html::img('@web/image/user-160.png', ['class' => "img-circle", 'alt' => "User Image"]);
                }
                ?>
            </div>
            <div class="pull-left info">
                <p>
                    <?php
                    $name = Yii::$app->user->identity->profile->name;
                    $label = empty($name) ? Yii::$app->user->identity->username : $name;

                    echo Html::a($label, ['/user/settings/profile']);
                    ?>
                </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="<?= Url::to(['/site/search']) ?>" method="get" class="sidebar-form">
            <div class="input-group">
                <input
                    type="text"
                    name="number"
                    class="form-control mytooltip"
                    placeholder="<?= Yii::t('app', 'Search Container') ?>..."
                    id="navbar-search-input"
                    title="Type the 11-digit number of container, with no spaces"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    maxlength="11"
                    />
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Booking Request'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Job Container'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cube',
                        'url' => ['/job-container'],
                    ],
                    [
                        'label' => Yii::t('app', 'Shipping Instruction'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-newspaper-o',
                        'url' => ['/shipping-instruction'],
                    ],
                    [
                        'label' => 'Master',
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Shipper'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-industry',
                        'url' => ['/company-profile/shipper'],
                    ],
                    [
                        'label' => Yii::t('app', 'Stuffing Location'),
                        'encode' => FALSE,
                        'icon' => 'glyphicon glyphicon-log-in',
                        'url' => ['/stuffing-location'],
                    ],
                    [
                        'label' => Yii::t('app', 'Shipping'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-ship',
                        'url' => ['/company-profile/shipping'],
                    ],
                    [
                        'label' => Yii::t('app', 'Container Port'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-map-marker',
                        'url' => ['/container-port'],
                    ],
                    [
                        'label' => Yii::t('app', 'Container Depo'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-cubes',
                        'url' => ['/company-profile/depo'],
                    ],
                    [
                        'label' => Yii::t('app', 'Truck Vendor'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-truck',
                        'url' => ['/company-profile/truck-vendor'],
                    ],
                    [
                        'label' => Yii::t('app', 'Mandor'),
                        'encode' => FALSE,
                        'icon' => 'fa fa-user-circle-o',
                        'url' => ['/truck-supervisor'],
                    ],
                    [
                        'label' => 'Administrator',
                        'visible' => ActiveUser::isAdmin(),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => 'User Management',
                        'visible' => ActiveUser::isAdmin(),
                        'encode' => FALSE,
                        'icon' => 'fa fa-user',
                        'url' => ['/user/admin'],
                    ],
                    [
                        'label' => Yii::t('app', 'Pages'),
                        'options' => ['class' => 'header'],
                    ],
                    [
                        'label' => Yii::t('app', 'Office Branches'),
                        'icon' => 'fa fa-page',
                        'url' => ['/site/page', 'slug' => 'branches'],
                    ],
                    [
                        'label' => 'Development',
                        'options' => ['class' => 'header'],
                        'visible' => YII_DEBUG,
                    ],
                    [
                        'label' => 'Yii2',
                        'visible' => YII_DEBUG,
                        'icon' => 'fa fa-gears',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                        ],
                    ],
                ],
            ]
        )
        ?>

    </section>

</aside>
