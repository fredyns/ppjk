<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "ContainerPortController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\ContainerPortActControl;

class ContainerPortController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\ContainerPort';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        ContainerPortActControl::checkAccess($action, $model, $params);
    }
}
