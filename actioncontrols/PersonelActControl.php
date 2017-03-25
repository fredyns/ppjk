<?php

namespace app\actioncontrols;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use fredyns\suite\helpers\ActiveUser;
use kartik\icons\Icon;
use app\models\CompanyProfile;
use app\models\Personel;

/**
 * Personel model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property Personel $model data model
 * @property boolean $allowDriverList is allowing get driver list in json
 */
class PersonelActControl extends \fredyns\suite\libraries\ActionControl
{
    const ACTION_DRIVERLIST = 'driver-list';

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/personel';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'Personel',
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
     * get URL param for create action
     *
     * @return array
     */
    public function getUrlCreate()
    {
        return [
            $this->actionRoute(static::ACTION_CREATE),
            'ru' => ReturnUrl::getToken(),
            'PersonelForm' => [
                'companyProfile_id' => CompanyProfile::SELFCOMPANY,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getAllowIndex($params = array())
    {
        $action = static::ACTION_INDEX;

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * check permission to access Deleted page
     *
     * @return boolean
     */
    public function getAllowDeleted($params = [])
    {
        $action = static::ACTION_DELETED;

        // blacklist
        if (ActiveUser::isAdmin() == FALSE) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * check permission to get driver list in json
     *
     * @param array $params
     * @return boolean
     */
    public function getAllowDriverList($params = [])
    {
        $action = 'driver-list';

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * @inheritdoc
     */
    public function getAllowCreate($params = array())
    {
        $action = static::ACTION_CREATE;

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * @inheritdoc
     */
    public function getAllowView($params = array())
    {
        $action = static::ACTION_VIEW;

        // prerequisites
        parent::getAllowView($params);

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * @inheritdoc
     */
    public function getAllowUpdate($params = array())
    {
        $action = static::ACTION_UPDATE;

        // prerequisites
        parent::getAllowUpdate($params);

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * @inheritdoc
     */
    public function getAllowDelete($params = array())
    {
        $action = static::ACTION_DELETE;

        // prerequisites
        parent::getAllowDelete($params);

        // blacklist
        if (ActiveUser::isAdmin() == FALSE) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    /**
     * @inheritdoc
     */
    public function getAllowRestore($params = array())
    {
        $action = static::ACTION_RESTORE;

        // prerequisites
        parent::getAllowRestore($params);

        // blacklist
        if (ActiveUser::isAdmin()) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
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