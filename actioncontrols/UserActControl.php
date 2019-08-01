<?php

namespace app\actioncontrols;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use kartik\icons\Icon;
use app\models\User;

/**
 * User model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property User $model data model
 */
class UserActControl extends \fredyns\suite\libraries\ActionControl
{

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/user';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'User',
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

    /**
     * check permission to get model list in json
     *
     * @param array $params
     * @return boolean
     */
    public function getAllowList($params = [])
    {
        return true;
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