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
use yii\db\Query;
use app\models\ShippingInstruction;

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
                ->select('id, number AS text')
                ->from('shippingInstruction')
                ->where(['like', 'number', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = ShippingInstruction::findOne($id);

            if ($model) {
                $out['results'] = [
                    'id' => $id,
                    'text' => $model->number,
                ];
            }
        }
        return $out;
    }
}