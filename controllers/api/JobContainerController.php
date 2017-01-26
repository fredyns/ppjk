<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "JobContainerController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\JobContainerActControl;

class JobContainerController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\JobContainer';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        JobContainerActControl::checkAccess($action, $model, $params);
    }
}
