<?php

namespace app\actioncontrols;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use fredyns\suite\helpers\ActiveUser;
use kartik\icons\Icon;
use app\models\JobContainer;

/**
 * JobContainer model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property JobContainer $model data model
 */
class JobContainerActControl extends \fredyns\suite\libraries\ActionControl
{

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/job-container';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'JobContainer',
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function modelLabel()
    {
        return ($this->model->containerNumber) ? $this->model->containerNumber : '#'.$this->model->id;
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