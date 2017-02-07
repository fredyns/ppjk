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
use yii\db\Query;
use app\models\Personel;
use app\models\Profile;
use app\models\CompanyProfile;

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

    /**
     * providing driver list company
     *
     * @param string $q
     * @param integer $id
     * @return mixed
     */
    public function actionDriverList($q = null, $id = null)
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
                ->select('profile.id, profile.name AS text')
                ->from('profile')
                ->innerJoin('personel', 'profile.id = personel.profile_id')
                ->andWhere([
                    'personel.companyProfile_id' => CompanyProfile::SELFCOMPANY,
                ])
                ->andWhere([
                    'or',
                    ['like', 'personel.title', 'driver'],
                    ['like', 'personel.title', 'sopir'],
                ])
                ->andWhere(['like', 'profile.name', $q])
                ->limit(20);

            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $model = Profile::findOne($id);

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