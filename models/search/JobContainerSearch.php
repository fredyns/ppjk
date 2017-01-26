<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JobContainer;

/**
 * JobContainerSearch represents the model behind the search form about `app\models\JobContainer`.
 */
class JobContainerSearch extends JobContainer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shippingInstruction_id', 'stuffingLocation_id', 'driver_id', 'supervisor_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'], 'integer'],
            [['containerNumber', 'sealNumber', 'stuffingDate', 'recordStatus'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = JobContainer::find();

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
            'shippingInstruction_id' => $this->shippingInstruction_id,
            'stuffingDate' => $this->stuffingDate,
            'stuffingLocation_id' => $this->stuffingLocation_id,
            'driver_id' => $this->driver_id,
            'supervisor_id' => $this->supervisor_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query
            ->andFilterWhere(['like', 'containerNumber', $this->containerNumber])
            ->andFilterWhere(['like', 'sealNumber', $this->sealNumber])
            ->andFilterWhere(['like', 'recordStatus', $this->recordStatus]);

        return $dataProvider;
    }
}
