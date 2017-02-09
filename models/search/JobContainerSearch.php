<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\JobContainer;

/**
 * JobContainerSearch represents the model behind the search form about `app\models\JobContainer`.
 */
class JobContainerSearch extends JobContainer
{
    public $shippingInstructionNumber;
    public $shipperName;
    public $shippingName;
    public $destinationName;
    public $stuffingLocationName;
    public $driverName;
    public $supervisorName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [
                [
                    'shippingInstructionNumber', 'containerNumber', 'sealNumber',
                    'stuffingLocationName', 'driverName', 'supervisorName',
                    'recordStatus',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
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
        $query = JobContainer::find()
            ->with('shippingInstruction')
            ->with('shippingInstruction.shipper')
            ->with('shippingInstruction.shipping')
            ->with('shippingInstruction.destination')
            ->with('stuffingLocation')
            ->with('supervisor');

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
                static::tableName().'.id' => $this->id,
                static::tableName().'.stuffingDate' => $this->stuffingDate,
                static::tableName().'.supervisor_id' => $this->supervisor_id,
                static::tableName().'.recordStatus' => $this->recordStatus,
                static::tableName().'.created_by' => $this->created_by,
                static::tableName().'.updated_by' => $this->updated_by,
                static::tableName().'.deleted_by' => $this->deleted_by,
        ]);

        $query
            ->andFilterWhere(['like', static::tableName().'.containerNumber', $this->containerNumber])
            ->andFilterWhere(['like', static::tableName().'.sealNumber', $this->sealNumber])
            ->andFilterWhere([
                'like',
                \app\models\ShippingInstruction::tableName().'.number',
                $this->shippingInstructionNumber,
            ])
            ->andFilterWhere([
                'like',
                \app\models\ShippingInstruction::ALIAS_SHIPPER.'.name',
                $this->shipperName,
            ])
            ->andFilterWhere([
                'like',
                \app\models\Shipping::tableName().'.name',
                $this->shippingName,
            ])
            ->andFilterWhere([
                'like',
                \app\models\ShippingInstruction::ALIAS_DESTINATION.'.name',
                $this->destinationName,
            ])
            ->andFilterWhere([
                'like',
                \app\models\StuffingLocation::tableName().'.name',
                $this->stuffingLocationName,
            ])
            ->andFilterWhere([
                'like',
                static::ALIAS_DRIVER.'.name',
                $this->driverName,
            ])
            ->andFilterWhere([
                'like',
                static::ALIAS_SUPERVISOR.'.name',
                $this->supervisorName,
        ]);

        $query->orderBy([
            static::tableName().'.id' => SORT_DESC,
        ]);

        return $dataProvider;
    }
}