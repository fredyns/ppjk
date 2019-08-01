<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;
use app\models\CompanyProfile;
use app\models\search\CompanyProfileSearch;
use app\models\form\CompanyProfileForm;
use app\actioncontrols\CompanyProfileActControl;
use yii\filters\VerbFilter;
use fredyns\suite\filters\AdminLTELayout;

/**
 * This is the class for controller "CompanyProfileController".
 */
class CompanyProfileController extends \app\controllers\base\CompanyProfileController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'layout' => [
                'class' => AdminLTELayout::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all active shipper models.
     * @return mixed
     */
    public function actionShipper()
    {
        $searchModel = new CompanyProfileSearch;
        $dataProvider = $searchModel->searchShipper($_GET);
        $actionControl = CompanyProfileActControl::checkAccess('shipper', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('shipper',
                [
                'dataProvider' => $dataProvider,
                'actionControl' => $actionControl,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all active shipping models.
     * @return mixed
     */
    public function actionShipping()
    {
        $searchModel = new CompanyProfileSearch;
        $dataProvider = $searchModel->searchShipping($_GET);
        $actionControl = CompanyProfileActControl::checkAccess('shipping', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('shipping',
                [
                'dataProvider' => $dataProvider,
                'actionControl' => $actionControl,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all active depo models.
     * @return mixed
     */
    public function actionDepo()
    {
        $searchModel = new CompanyProfileSearch;
        $dataProvider = $searchModel->searchDepo($_GET);
        $actionControl = CompanyProfileActControl::checkAccess('depo', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('depo',
                [
                'dataProvider' => $dataProvider,
                'actionControl' => $actionControl,
                'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all active truck-vendor models.
     * @return mixed
     */
    public function actionTruckVendor()
    {
        $searchModel = new CompanyProfileSearch;
        $dataProvider = $searchModel->searchTruckVendor($_GET);
        $actionControl = CompanyProfileActControl::checkAccess('truck-vendor', $searchModel);

        Tabs::clearLocalStorage();
        Url::remember();

        return $this->render('truck-vendor',
                [
                'dataProvider' => $dataProvider,
                'actionControl' => $actionControl,
                'searchModel' => $searchModel,
        ]);
    }
}