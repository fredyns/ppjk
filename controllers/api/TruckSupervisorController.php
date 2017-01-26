<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "TruckSupervisorController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\TruckSupervisorActControl;

class TruckSupervisorController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\TruckSupervisor';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        TruckSupervisorActControl::checkAccess($action, $model, $params);
    }
}
