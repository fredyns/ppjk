<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "ShippingInstructionController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\ShippingInstructionActControl;

class ShippingInstructionController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\ShippingInstruction';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        ShippingInstructionActControl::checkAccess($action, $model, $params);
    }
}
