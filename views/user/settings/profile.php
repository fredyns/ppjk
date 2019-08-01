<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\Profile $profile
 */
$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <?php
                $form = \yii\widgets\ActiveForm::begin([
                        'id' => 'profile-form',
                        'options' => ['class' => 'form-horizontal'],
                        'fieldConfig' => [
                            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                            'labelOptions' => ['class' => 'col-lg-3 control-label'],
                        ],
                        'enableAjaxValidation' => true,
                ]);
                ?>

                <?php if (!empty($model->picture_id)): ?>

                    <div class="col-md-4">
                        <p>
                            <?=
                            Html::img(
                                ['/file', 'id' => $model->picture_id],
                                [
                                'class' => 'img-rounded img-responsive',
                                'alt' => $model->user->username,
                                ]
                            )
                            ?>
                        </p>
                    </div>

                    <div class="clearfix"></div>

                <?php endif; ?>

                <?= $form->field($model, 'picture')->label('Picture')->fileInput(); ?>

                <!-- attribute name -->
                <?=
                $form->field($model, 'name')->textInput(['maxlength' => true])
                ?>

                <!-- attribute phone -->
                <?=
                $form->field($model, 'phone')->textInput(['maxlength' => true])
                ?>

                <!-- attribute public_email -->
                <?=
                $form->field($model, 'public_email')->textInput(['maxlength' => true])
                ?>

                <!-- attribute address -->
                <?=
                $form->field($model, 'address')->textarea(['rows' => 6])
                ?>

                <!-- attribute bio -->
                <?=
                $form->field($model, 'bio')->textarea(['rows' => 6])
                ?>

                <!-- attribute website -->
                <?=
                $form->field($model, 'website')->textInput(['maxlength' => true])
                ?>

                <!-- attribute timezone -->
                <?=
                    $form
                    ->field($model, 'timezone')
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::map(
                            \dektrium\user\helpers\Timezone::getAll(), 'timezone', 'name'
                        )
                );
                ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <?=
                        \yii\helpers\Html::submitButton(
                            Yii::t('user', 'Save'), ['class' => 'btn btn-block btn-success']
                        )
                        ?><br>
                    </div>
                </div>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/places.js/1/places.min.js"></script>
<script>
    var placesAutocomplete = places({
        container: document.querySelector('#profile-location')
    });
</script>
