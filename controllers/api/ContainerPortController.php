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
use yii\db\Query;
use app\models\ContainerPort;

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

    /**
     * profiding model list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionList($q = null, $id = null)
    {
        $minimumInputLength = 1;
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
                ->from('containerPort')
                ->where(['like', 'name', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = ContainerPort::findOne($id);

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