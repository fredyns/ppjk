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
 *
 * @property string $allowCopy is allowing accessing copy page
 * @property array $urlCopy url config for Copy page
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
        return ($this->model->containerNumber) ? $this->model->containerNumber : str_repeat('&nbsp; ', 11);
    }

    /**
     * @inheritdoc
     */
    public function actionPersistentModel()
    {
        return [static::ACTION_VIEW, static::ACTION_UPDATE, 'copy', static::ACTION_DELETE, static::ACTION_RESTORE];
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
                'copy' => [
                    'label' => 'Copy',
                    'url' => $this->urlCopy,
                    'icon' => Icon::show('copy'),
                    'linkOptions' => [
                        'title' => 'copy cargo details',
                        'aria-label' => 'Copy',
                        'data-pjax' => '0',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                    ],
                ],
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
     * get URL param to copy model
     *
     * @return array
     */
    public function getUrlCopy()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('create');
            $param['ru'] = ReturnUrl::getToken();
            $param['JobContainerForm'] = $this->model->attributes;

            return $param;
        }

        return [];
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
    /*     * *
     * check wether user can create similiar job
     */

    public function getAllowCopy($params = [])
    {
        return $this->getAllowCreate($params);
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