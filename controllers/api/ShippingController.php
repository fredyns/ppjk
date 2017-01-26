<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "ShippingController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\ShippingActControl;

class ShippingController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Shipping';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        ShippingActControl::checkAccess($action, $model, $params);
    }
}
