<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "CompanyTypeController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\CompanyTypeActControl;

class CompanyTypeController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\CompanyType';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        CompanyTypeActControl::checkAccess($action, $model, $params);
    }
}
