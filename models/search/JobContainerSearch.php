<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use fredyns\suite\helpers\StringHelper;
use app\models\JobContainer;
use app\models\ShippingInstruction;
use app\models\StuffingLocation;
use app\models\TruckSupervisor;

/**
 * JobContainerSearch represents the model behind the search form about `app\models\JobContainer`.
 */
class JobContainerSearch extends JobContainer
{
    // shipping instruction
    public $shippingInstructionNumber;
    public $shipper_id;
    public $shipperName;
    public $shipping_id;
    public $shippingName;
    public $destination_id;
    public $destinationName;
    // job container
    public $stuffingDateRange;
    public $containerDepoName;
    public $stuffingLocationName;
    public $supervisorName;
    public $truckVendorName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // shipping instruction
            [
                [
                    'shippingInstructionNumber',
                    'shipperName',
                    'shippingName',
                    'destinationName',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            // job container
            [['id', 'type_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [
                [
                    'containerNumber',
                    'size',
                    'sealNumber',
                    'containerDepoName',
                    'stuffingLocationName',
                    'supervisorName',
                    'truckVendorName',
                    'driverName',
                    'cellphone',
                    'policenumber',
                    'notes',
                    'recordStatus',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
            [['stuffingDateRange'], 'safe'],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
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
            ->joinWith('shippingInstruction')
            ->joinWith('stuffingLocation')
            ->joinWith('truckVendor')
            ->joinWith('supervisor')
            ->joinWith('shippingInstruction.shipper')
            ->joinWith('shippingInstruction.shipping')
            ->joinWith('shippingInstruction.destination');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => [
                    // SI
                    'shippingInstructionNumber' => [
                        'asc' => [ShippingInstruction::tableName().'.number' => SORT_ASC],
                        'desc' => [ShippingInstruction::tableName().'.number' => SORT_DESC],
                    ],
                    'shipperName' => [
                        'asc' => [ShippingInstruction::ALIAS_SHIPPER.'.name' => SORT_ASC],
                        'desc' => [ShippingInstruction::ALIAS_SHIPPER.'.name' => SORT_DESC],
                    ],
                    'destinationName' => [
                        'asc' => [ShippingInstruction::ALIAS_DESTINATION.'.name' => SORT_ASC],
                        'desc' => [ShippingInstruction::ALIAS_DESTINATION.'.name' => SORT_DESC],
                    ],
                    // job container
                    'id',
                    'containerNumber',
                    'size',
                    'type_id' => [
                        'asc' => [static::ALIAS_TYPE.'.name' => SORT_ASC],
                        'desc' => [static::ALIAS_TYPE.'.name' => SORT_DESC],
                    ],
                    'sealNumber',
                    'stuffingDate',
                    'containerDepoName' => [
                        'asc' => [static::ALIAS_CONTAINERDEPO.'.name' => SORT_ASC],
                        'desc' => [static::ALIAS_CONTAINERDEPO.'.name' => SORT_DESC],
                    ],
                    'stuffingLocationName' => [
                        'asc' => [StuffingLocation::tableName().'.name' => SORT_ASC],
                        'desc' => [StuffingLocation::tableName().'.name' => SORT_DESC],
                    ],
                    'truckVendorName' => [
                        'asc' => [TruckSupervisor::tableName().'.name' => SORT_ASC],
                        'desc' => [TruckSupervisor::tableName().'.name' => SORT_DESC],
                    ],
                    'driverName',
                    'cellphone',
                    'policenumber',
                ],
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere([
            // shipping instruction
            ShippingInstruction::tableName().'.shipper_id' => $this->shipper_id,
            ShippingInstruction::tableName().'.shipping_id' => $this->shipping_id,
            ShippingInstruction::tableName().'.destination_id' => $this->destination_id,
            // job container
            static::tableName().'.id' => $this->id,
            static::tableName().'.shippingInstruction_id' => $this->shippingInstruction_id,
            static::tableName().'.size' => $this->size,
            static::tableName().'.type_id' => $this->type_id,
            static::tableName().'.stuffingDate' => $this->stuffingDate,
            static::tableName().'.containerDepo_id' => $this->containerDepo_id,
            static::tableName().'.stuffingLocation_id' => $this->stuffingLocation_id,
            static::tableName().'.supervisor_id' => $this->supervisor_id,
            static::tableName().'.truckVendor_id' => $this->truckVendor_id,
            static::tableName().'.recordStatus' => $this->recordStatus,
            static::tableName().'.created_by' => $this->created_by,
            static::tableName().'.updated_by' => $this->updated_by,
            static::tableName().'.deleted_by' => $this->deleted_by,
        ]);

        // shipping instruction
        $query
            ->andFilterWhere(['like', ShippingInstruction::tableName().'.number', $this->shippingInstructionNumber])
            ->andFilterWhere(['like', ShippingInstruction::ALIAS_SHIPPER.'.name', $this->shipperName])
            ->andFilterWhere(['like', ShippingInstruction::ALIAS_SHIPPING.'.name', $this->shippingName])
            ->andFilterWhere(['like', ShippingInstruction::ALIAS_DESTINATION.'.name', $this->destinationName]);

        // job container
        $query
            ->andFilterWhere(['like', static::tableName().'.containerNumber', $this->containerNumber])
            ->andFilterWhere(['like', static::tableName().'.sealNumber', $this->sealNumber])
            ->andFilterWhere(['like', static::ALIAS_CONTAINERDEPO.'.name', $this->containerDepoName])
            ->andFilterWhere(['like', StuffingLocation::tableName().'.name', $this->stuffingLocationName])
            ->andFilterWhere(['like', static::ALIAS_SUPERVISOR.'.name', $this->supervisorName])
            ->andFilterWhere(['like', static::ALIAS_TRUCKVENDOR.'.name', $this->truckVendorName])
            ->andFilterWhere(['like', static::tableName().'.driverName', $this->driverName])
            ->andFilterWhere(['like', static::tableName().'.cellphone', $this->cellphone])
            ->andFilterWhere(['like', static::tableName().'.policenumber', $this->policenumber])
            ->andFilterWhere(['like', static::tableName().'.notes', $this->notes]);

        // stuffing date range
        if (!empty($this->stuffingDateRange) && (strpos($this->stuffingDateRange, '-') !== false)) {
            list($start_date, $end_date) = explode(' - ', $this->stuffingDateRange);

            $start_date = trim($start_date);
            $end_date = trim($end_date);
            $start = date_create_from_format('m/d/Y', $start_date);
            $end = date_create_from_format('m/d/Y', $end_date);

            if ($start && $end) {
                $query->andFilterWhere([
                    'between',
                    static::tableName().'.stuffingDate',
                    $start->format('Y-m-d'),
                    $end->format('Y-m-d'),
                ]);
            }
        }

        return $dataProvider;
    }
}