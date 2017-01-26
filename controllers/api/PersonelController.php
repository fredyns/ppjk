<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "PersonelController".
 * empowered with logic base access control
 */

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\PersonelActControl;

class PersonelController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\Personel';

    
    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        PersonelActControl::checkAccess($action, $model, $params);
    }
}
