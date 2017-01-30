<?php

namespace app\models\form;

use Yii;
use yii\helpers\ArrayHelper;
use fredyns\suite\behaviors\BelongingModelBehavior;
use fredyns\suite\helpers\StringHelper;
use app\models\JobContainer;

/**
 * This is the form model class for table "jobContainer".
 */
class JobContainerForm extends JobContainer
{
    public $shipperId;
    public $shipperAddress;
    public $shipperPhone;
    public $shipperEmail;
    public $shipperNpwp;
    public $shippingId;
    public $destinationId;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
                parent::behaviors(),
                [
                # custom behaviors
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => ShippingInstructionForm::className(),
                    'relatedAttribute' => 'shippingInstruction_id',
                    'valueAttribute' => 'number',
                    'otherAttributes' => [
                        'shipper_id' => 'shipperId',
                        'shipperAddress' => 'shipperAddress',
                        'shipperPhone' => 'shipperPhone',
                        'shipperEmail' => 'shipperEmail',
                        'shipperNpwp' => 'shipperNpwp',
                        'shipping_id' => 'shippingId',
                        'destination_id' => 'destinationId',
                    ],
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => StuffingLocationForm::className(),
                    'relatedAttribute' => 'stuffingLocation_id',
                    'valueAttribute' => 'name',
                ],
                [
                    'class' => BelongingModelBehavior::className(),
                    'modelClass' => TruckSupervisorForm::className(),
                    'relatedAttribute' => 'supervisor_id',
                    'valueAttribute' => 'name',
                ],
                ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /* filter */
            [
                [
                    'shippingInstruction_id',
                    'containerNumber', 'sealNumber', 'worknote',
                    'stuffingLocation_id', 'supervisor_id',
                    'shipperId', 'shippingId', 'destinationId',
                    'shipperAddress', 'shipperPhone', 'shipperEmail', 'shipperNpwp',
                ],
                'filter',
                'filter' => function($value) {

                    return StringHelper::plaintextFilter($value);
                },
            ],
            /* default value */
            ['recordStatus', 'default', 'value' => static::RECORDSTATUS_ACTIVE],
            /* required */
            [['shippingInstruction_id', 'containerNumber'], 'required'],
            [
                ['shipperId', 'shippingId', 'destinationId'],
                'required',
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->shippingInstruction_id) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        shipperInput = $(\'#'.$this->formName().'-shippingInstruction_id\').val();

                        return (shipperInput && isNaN(shipperInput));
                    }',
            ],
            [
                ['shipperAddress', 'shipperPhone'],
                'required',
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->shipperId) == FALSE);
                },
                'whenClient' => '
                    function (attribute, value) {
                        shipperInput = $(\'#'.$this->formName().'-shipperId\').val();

                        return (shipperInput && isNaN(shipperInput));
                    }',
            ],
            /* safe */
            /* field type */
            [['driver_id'], 'integer'],
            [['recordStatus', 'worknote'], 'string'],
            [['containerNumber'], 'string', 'max' => 32],
            [['sealNumber'], 'string', 'max' => 64],
            [
                [
                    'shippingInstruction_id', 'stuffingLocation_id', 'supervisor_id',
                    'shipperId', 'shippingId', 'destinationId',
                ],
                'string',
                'max' => 255,
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute) == FALSE);
                },
            ],
            [['shipperAddress'], 'string'],
            [['shipperPhone'], 'string', 'max' => 255],
            [['shipperEmail'], 'string', 'max' => 64],
            [['shipperNpwp'], 'string', 'max' => 32],
            /* value limitation */
            [['stuffingDate'], 'date', 'format' => 'php:Y-m-d'],
            ['recordStatus', 'in', 'range' => [
                    self::RECORDSTATUS_ACTIVE,
                    self::RECORDSTATUS_DELETED,
                ]
            ],
            [['shipperEmail'], 'email'],
            /* value references */
            [
                ['shippingInstruction_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\ShippingInstruction::className(),
                'targetAttribute' => ['shippingInstruction_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['stuffingLocation_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\StuffingLocation::className(),
                'targetAttribute' => ['stuffingLocation_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['driver_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Profile::className(),
                'targetAttribute' => ['driver_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['supervisor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\TruckSupervisor::className(),
                'targetAttribute' => ['supervisor_id' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shipperId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\CompanyProfile::className(),
                'targetAttribute' => ['shipperId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['shippingId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\Shipping::className(),
                'targetAttribute' => ['shippingId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
            [
                ['destinationId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => \app\models\ContainerPort::className(),
                'targetAttribute' => ['destinationId' => 'id'],
                'when' => function ($model, $attribute) {
                    return (is_numeric($model->$attribute));
                },
            ],
        ];
    }
}