<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "StuffingLocationController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\StuffingLocationActControl;

class StuffingLocationController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\StuffingLocation';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        StuffingLocationActControl::checkAccess($action, $model, $params);
    }
}
