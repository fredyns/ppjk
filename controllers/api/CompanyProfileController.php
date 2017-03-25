<?php

namespace app\controllers\api;

/**
 * This is the class for REST controller "CompanyProfileController".
 * empowered with logic base access control
 */
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use app\actioncontrols\CompanyProfileActControl;
use yii\db\Query;
use app\models\CompanyProfile;

class CompanyProfileController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\CompanyProfile';

    /**
     * @inheritdoc
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        CompanyProfileActControl::checkAccess($action, $model, $params);
    }

    /**
     * profiding company list
     *
     * @param string $q
     * @param integer $id
     * @param integer $type_id
     * @return mixed
     */
    public function actionList($q = null, $id = null, $type_id = null)
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
                ->from('companyProfile')
                ->where([
                    'or',
                    ['like', 'npwp', $q],
                    ['like', 'name', $q],
                ])
                ->limit(20);

            if ($type_id > 0) {
                $query->andWhere(['companyType_id' => $type_id]);
            }

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = CompanyProfile::findOne($id);

            if ($model) {
                $out['results'] = [
                    'id' => $id,
                    'text' => $model->name,
                ];
            }
        }
        return $out;
    }

    /**
     * profiding shipper list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionListShipper($q = null, $id = null)
    {
        return $this->actionList($q, $id, CompanyProfile::TYPE_SHIPPER);
    }

    /**
     * profiding shipping list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionListShipping($q = null, $id = null)
    {
        return $this->actionList($q, $id, CompanyProfile::TYPE_SHIPPING);
    }

    /**
     * profiding container depo list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionListDepo($q = null, $id = null)
    {
        return $this->actionList($q, $id, CompanyProfile::TYPE_DEPO);
    }

    /**
     * profiding truck vendor list
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionListTruckVendor($q = null, $id = null)
    {
        return $this->actionList($q, $id, CompanyProfile::TYPE_TRUCKVENDOR);
    }
}