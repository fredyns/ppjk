<?php
/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View                    $this
 * @var dektrium\user\models\User       $user
 * @var dektrium\user\models\Profile    $profile
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php
$form = ActiveForm::begin([
        'layout' => 'horizontal',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'wrapper' => 'col-sm-9',
            ],
        ],
    ]);
?>

<!-- attribute picture -->

<?php if (!empty($profile->picture_id)): ?>
    <div class="form-group field-profile-display">
        <label class="control-label col-sm-3" for="profile-picture">&nbsp;</label>
        <div class="col-sm-9">
            <p>
                <?=
                Html::img(
                    ['/file', 'id' => $profile->picture_id],
                    [
                    'class' => 'img-responsive',
                    'alt' => 'picture',
                    ]
                )
                ?>
            </p>
        </div>

    </div>

    <div class="clearfix"></div>

<?php endif; ?>

<?= $form->field($profile, 'picture')->label('Picture')->fileInput(); ?>
<?= $form->field($profile, 'name') ?>
<?= $form->field($profile, 'public_email') ?>
<?= $form->field($profile, 'website') ?>
<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'bio')->textarea() ?>


<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
        <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
