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
use yii\db\Query;
use app\models\TruckSupervisor;

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

    /**
     * providing model list in json
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionList($q = null, $id = null)
    {
        $minimumInputLength = 3;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [
            'results' => [
                'id' => '',
                'text' => '',
            ],
        ];

        if (!is_null($q) && strlen($q) >= $minimumInputLength) {
            $query = new Query;

            $query
                ->select('id, name AS text')
                ->from('truckSupervisor')
                ->where(['like', 'name', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = TruckSupervisor::findOne($id);

            if ($model) {
                $out['results'] = [
                    'id' => $id,
                    'text' => $model->name,
                ];
            }
        }
        return $out;
    }
}