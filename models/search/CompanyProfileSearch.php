<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CompanyProfile;

/**
 * CompanyProfileSearch represents the model behind the search form about `app\models\CompanyProfile`.
 */
class CompanyProfileSearch extends CompanyProfile
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'companyType_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['name', 'address', 'phone', 'email', 'npwp', 'recordStatus'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * search models
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchIndex($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;

        return $this->search();
    }

    /**
     * search deleted models
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchDeleted($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_DELETED;

        return $this->search();
    }

    /**
     * search shipper
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchShipper($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;
        $this->companyType_id = static::TYPE_SHIPPER;

        return $this->search();
    }

    /**
     * search shipping
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchShipping($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;
        $this->companyType_id = static::TYPE_SHIPPING;

        return $this->search();
    }

    /**
     * search container depo
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchDepo($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;
        $this->companyType_id = static::TYPE_DEPO;

        return $this->search();
    }

    /**
     * search truck vendor
     *
     * @param array   $params
     *
     * @return ActiveDataProvider
     */
    public function searchTruckVendor($params)
    {
        $this->load($params);

        $this->recordStatus = static::RECORDSTATUS_ACTIVE;
        $this->companyType_id = static::TYPE_TRUCKVENDOR;

        return $this->search();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = CompanyProfile::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere([
                'id' => $this->id,
                'companyType_id' => $this->companyType_id,
                'recordStatus' => $this->recordStatus,
                'created_by' => $this->created_by,
                'updated_by' => $this->updated_by,
                'deleted_by' => $this->deleted_by,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'npwp', $this->npwp]);

        return $dataProvider;
    }
}