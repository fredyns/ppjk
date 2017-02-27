<?php

namespace app\actioncontrols;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use kartik\icons\Icon;
use app\models\DailyDriving;

/**
 * DailyDriving model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property DailyDriving $model data model
 */
class DailyDrivingActControl extends \fredyns\suite\libraries\ActionControl
{

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/daily-driving';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'DailyDriving',
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function modelLabel()
    {
        return parent::modelLabel();
    }

    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [
            'forbidden' => "%s tidak diperbolehkan.",
            'notconfigured' => "%s belum dikonfigurasi dengan benar.",
            'model-unknown' => "Data tidak diketahui.",
            'model-unsaved' => "Tak dapat melakukan %s data yang belum tersimpan.",
            'model-deleted' => "Data sudah terhapus (soft-delete).",
            'model-active' => "Data belum terhapus.",
            'softdelete-unsupported' => "Data tidak mendukung soft-delete.",
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionPersistentModel()
    {
        return ArrayHelper::merge(
                parent::actionPersistentModel(), [
                #  additional action name
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actionUnspecifiedModel()
    {
        return ArrayHelper::merge(
                parent::actionUnspecifiedModel(), [
                # additional action name
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return ArrayHelper::merge(
                parent::actions(),
                [
                /* / action sample / */

                # 'action_name' => [
                #     'label'         => 'Action_Label',
                #     'url'           => $this->urlAction,
                #     'icon'          => Icon::show('star'),
                #     'linkOptions'   => [
                #         'title'      => 'click to do action',
                #         'aria-label' => 'Action_Label',
                #         'data-pjax'  => '0',
                #     ],
                #     'buttonOptions' => [
                #         'class' => 'btn btn-default',
                #     ],
                # ],
                ]
        );
    }
    ################################ sample : additional action ################################

    /**
     * get URL param to do action
     *
     * @return array
     */
    public function getUrlAction()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('action_slug');
            $param['ru'] = ReturnUrl::getToken();

            return $param;
        }

        return [];
    }

    /**
     * check permission to do action
     *
     * @return boolean
     */
    public function getAllowAction($params = [])
    {
        return true;
    }
}