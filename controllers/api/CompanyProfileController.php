<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "CompanyProfileController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\CompanyProfileActControl;

class CompanyProfileController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\CompanyProfile';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        CompanyProfileActControl::checkAccess($action, $model, $params);
    }
}
