<?php

namespace app\actioncontrols;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use cornernote\returnurl\ReturnUrl;
use fredyns\suite\helpers\ActiveUser;
use kartik\icons\Icon;
use app\models\CompanyProfile;

/**
 * CompanyProfile model action control
 *
 * @author Fredy Nurman Saleh <email@fredyns.net>
 *
 * @property CompanyProfile $model data model
 *
 * @property array $urlShipper url config for view Shipper list
 * @property string $allowShipper is allowing accessing view Shipper list
 * @property array $urlShipping url config for view Shipping list
 * @property string $allowShipping is allowing accessing view Shipping list
 * @property array $urlDepo url config for view Depo list
 * @property string $allowDepo is allowing accessing view Depo list
 * @property array $urlTruckVendor url config for view TruckVendor list
 * @property string $allowTruckVendor is allowing accessing view TruckVendor list
 */
class CompanyProfileActControl extends \fredyns\suite\libraries\ActionControl
{

    /**
     * @inheritdoc
     */
    public function controllerRoute()
    {
        return '/company-profile';
    }

    /**
     * @inheritdoc
     */
    public function breadcrumbLabels()
    {
        return ArrayHelper::merge(
                parent::breadcrumbLabels(), [
                'index' => 'CompanyProfile',
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
        return ArrayHelper::merge(
                parent::messages(),
                [
                'deleteself' => "Can't delete main Company Profile.",
                'haspersonel' => "This Shipper has personel list.",
                'hassiservice' => "This Company had SI service(s) history.",
                'hassiorder' => "This Company had SI order(s) history.",
                'hascontainer' => "This Company had container rent(s) history.",
                'hastrucking' => "This Company had trucking history.",
                ]
        );
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
                'shipper' => [
                    'label' => 'Shipper',
                    'url' => $this->urlShipper,
                    'icon' => Icon::show('industry'),
                    'linkOptions' => [
                        'title' => 'click to view shipper list',
                        'aria-label' => 'Shipper',
                        'data-pjax' => '0',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                    ],
                ],
                'shipping' => [
                    'label' => 'Shipping',
                    'url' => $this->urlShipping,
                    'icon' => Icon::show('ship'),
                    'linkOptions' => [
                        'title' => 'click to view shipping list',
                        'aria-label' => 'Shipping',
                        'data-pjax' => '0',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                    ],
                ],
                'depo' => [
                    'label' => 'Depo',
                    'url' => $this->urlDepo,
                    'icon' => Icon::show('cubes'),
                    'linkOptions' => [
                        'title' => 'click to view depo list',
                        'aria-label' => 'Depo',
                        'data-pjax' => '0',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                    ],
                ],
                'truck-vendor' => [
                    'label' => 'Truck Vendor',
                    'url' => $this->urlTruckVendor,
                    'icon' => Icon::show('truck'),
                    'linkOptions' => [
                        'title' => 'click to view truck vendor list',
                        'aria-label' => 'Truck Vendor',
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
     * get URL param to view shipper
     *
     * @return array
     */
    public function getUrlShipper()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('shipper');
            $param['ru'] = ReturnUrl::getToken();

            return $param;
        }

        return [];
    }

    /**
     * get URL param to view shipping
     *
     * @return array
     */
    public function getUrlShipping()
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
     * get URL param to do action
     *
     * @return array
     */
    public function getUrlDepo()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('depo');
            $param['ru'] = ReturnUrl::getToken();

            return $param;
        }

        return [];
    }

    /**
     * get URL param to do action
     *
     * @return array
     */
    public function getUrlTruckVendor()
    {
        if ($this->model instanceof ActiveRecord) {
            $param = $this->modelParam();
            $param[0] = $this->actionRoute('truck-vendor');
            $param['ru'] = ReturnUrl::getToken();

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

    public function getAllowShipper($params = array())
    {
        return $this->getAllowIndex($params);
    }

    public function getAllowShipping($params = array())
    {
        return $this->getAllowIndex($params);
    }

    public function getAllowDepo($params = array())
    {
        return $this->getAllowIndex($params);
    }

    public function getAllowTruckVendor($params = array())
    {
        return $this->getAllowIndex($params);
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
     * check permission to get company profile list in json
     *
     * @param array $params
     * @return boolean
     */
    public function getAllowList($params = [])
    {
        $action = 'list';

        // blacklist
        if (Yii::$app->user->isGuest) {
            $this->addErrorMsg($action, 'forbidden', [$action]);
        }

        // conclusion
        return ($this->isError($action) == FALSE);
    }

    public function getAllowListShipper($params = [])
    {
        return $this->getAllowList($params);
    }

    public function getAllowListShipping($params = [])
    {
        return $this->getAllowList($params);
    }

    public function getAllowListDepo($params = [])
    {
        return $this->getAllowList($params);
    }

    public function getAllowListTruckVendor($params = [])
    {
        return $this->getAllowList($params);
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

        if ($this->model->id == CompanyProfile::SELFCOMPANY) {
            $this->addErrorMsg($action, 'deleteself');
        }

        if ($this->model->getPersonels()->count() > 0) {
            $this->addErrorMsg($action, 'haspersonel');
        }

        if ($this->model->getSiServices()->count() > 0) {
            $this->addErrorMsg($action, 'hassiservice');
        }

        if ($this->model->getSiOrders()->count() > 0) {
            $this->addErrorMsg($action, 'hassiorder');
        }

        if ($this->model->getContainerServices()->count() > 0) {
            $this->addErrorMsg($action, 'hascontainer');
        }

        if ($this->model->getTruckServices()->count() > 0) {
            $this->addErrorMsg($action, 'hastrucking');
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