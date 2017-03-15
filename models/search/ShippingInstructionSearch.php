<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\ShippingInstruction;

/**
 * ShippingInstructionSearch represents the model behind the search form about `app\models\ShippingInstruction`.
 */
class ShippingInstructionSearch extends ShippingInstruction
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* filter */
            [
                ['shipper_id', 'shipping_id', 'destination_id'],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            [['id', 'number', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['recordStatus'], 'safe'],
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
        $query = ShippingInstruction::find()
            ->joinWith('shipper')
            ->joinWith('shipping')
            ->joinWith('destination');

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

        $query->andFilterWhere([
            static::tableName().'.id' => $this->id,
            static::tableName().'.number' => $this->number,
            static::tableName().'.recordStatus' => $this->recordStatus,
            static::tableName().'.created_by' => $this->created_by,
            static::tableName().'.updated_by' => $this->updated_by,
            static::tableName().'.deleted_by' => $this->deleted_by,
        ]);

        if ($this->shipper_id > 0) {
            $query->andFilterWhere([
                static::tableName().'.shipper_id' => $this->shipper_id,
            ]);
        } elseif ($this->shipper_id) {
            $query->andFilterWhere(['like', static::ALIAS_SHIPPER.'.name', $this->shipper_id]);
        }

        if ($this->shipping_id > 0) {
            $query->andFilterWhere([
                static::tableName().'.shipping_id' => $this->shipping_id,
            ]);
        } elseif ($this->shipping_id) {
            $query->andFilterWhere(['like', static::ALIAS_SHIPPING.'.name', $this->shipping_id]);
        }

        if ($this->destination_id > 0) {
            $query->andFilterWhere([
                static::tableName().'.destination_id' => $this->destination_id,
            ]);
        } elseif ($this->destination_id) {
            $query->andFilterWhere(['like', static::ALIAS_DESTINATION.'.name', $this->destination_id]);
        }

        return $dataProvider;
    }
}